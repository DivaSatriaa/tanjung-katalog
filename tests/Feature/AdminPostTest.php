<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminPostTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create();
    }

    public function test_admin_post_pages_render(): void
    {
        $post = Post::factory()->create();

        $this->actingAs($this->admin)->get(route('admin.posts.index'))->assertOk()->assertSee($post->title);
        $this->actingAs($this->admin)->get(route('admin.posts.create'))->assertOk();
        $this->actingAs($this->admin)->get(route('admin.posts.edit', $post))->assertOk();
    }

    public function test_publishing_without_date_uses_current_time_and_stores_cover(): void
    {
        Storage::fake('public');
        $this->freezeSecond();

        $this->actingAs($this->admin)
            ->post(route('admin.posts.store'), [
                'title' => 'Pelatihan UMKM',
                'body' => 'Isi berita.',
                'status' => 'published',
                'cover_image' => UploadedFile::fake()->image('sampul.jpg'),
            ])
            ->assertRedirect(route('admin.posts.index'));

        $post = Post::firstOrFail();

        $this->assertSame('pelatihan-umkm', $post->slug);
        $this->assertTrue($post->published_at->equalTo(now()));
        Storage::disk('public')->assertExists($post->cover_image);
    }

    public function test_draft_without_date_has_no_published_at(): void
    {
        $this->actingAs($this->admin)->post(route('admin.posts.store'), [
            'title' => 'Draf Berita',
            'body' => 'Isi.',
            'status' => 'draft',
        ]);

        $this->assertNull(Post::firstOrFail()->published_at);
    }

    public function test_update_keeps_slug_and_original_publish_date(): void
    {
        $post = Post::factory()->create([
            'title' => 'Judul Lama',
            'slug' => 'judul-lama',
            'published_at' => now()->subWeek(),
        ]);
        $originalDate = $post->published_at;

        $this->actingAs($this->admin)
            ->put(route('admin.posts.update', $post), [
                'title' => 'Judul Lama',
                'body' => 'Isi diperbarui.',
                'status' => 'published',
            ])
            ->assertRedirect(route('admin.posts.index'));

        $post->refresh();
        $this->assertSame('judul-lama', $post->slug);
        $this->assertTrue($post->published_at->equalTo($originalDate));
    }

    public function test_cover_image_can_be_removed_and_post_deleted(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('posts/lama.jpg', 'x');
        $post = Post::factory()->create(['cover_image' => 'posts/lama.jpg']);

        $this->actingAs($this->admin)->put(route('admin.posts.update', $post), [
            'title' => $post->title,
            'body' => $post->body,
            'status' => 'published',
            'remove_cover_image' => '1',
        ]);

        $this->assertNull($post->fresh()->cover_image);
        Storage::disk('public')->assertMissing('posts/lama.jpg');

        $this->actingAs($this->admin)
            ->delete(route('admin.posts.destroy', $post))
            ->assertRedirect(route('admin.posts.index'));

        $this->assertSame(0, Post::count());
    }

    public function test_validation_messages_are_in_indonesian(): void
    {
        $this->actingAs($this->admin)
            ->from(route('admin.posts.create'))
            ->post(route('admin.posts.store'), ['status' => 'published'])
            ->assertSessionHasErrors([
                'title' => 'judul wajib diisi.',
                'body' => 'isi berita wajib diisi.',
            ]);
    }

    public function test_non_admin_cannot_manage_posts(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('admin.posts.index'))
            ->assertForbidden();
    }
}
