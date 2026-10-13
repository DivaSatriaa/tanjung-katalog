<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\Umkm;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminManagementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return array<string, mixed>
     */
    private function umkmPayload(Category $category, string $name): array
    {
        return [
            'category_id' => $category->id,
            'name' => $name,
            'status' => 'published',
        ];
    }

    public function test_guests_and_non_admin_users_cannot_open_admin_pages(): void
    {
        $this->get(route('admin.dashboard'))->assertRedirect('/admin/login');

        $this->actingAs(User::factory()->create())
            ->get(route('admin.dashboard'))
            ->assertForbidden();
    }

    public function test_admin_can_create_two_umkms_with_the_same_name(): void
    {
        $category = Category::factory()->create();
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post(route('admin.umkms.store'), $this->umkmPayload($category, 'Toko Barokah'))
            ->assertRedirect(route('admin.umkms.index'));

        $this->actingAs($admin)
            ->post(route('admin.umkms.store'), $this->umkmPayload($category, 'Toko Barokah'))
            ->assertRedirect(route('admin.umkms.index'));

        $this->assertSame(
            ['toko-barokah', 'toko-barokah-2'],
            Umkm::orderBy('id')->pluck('slug')->all(),
        );
    }

    public function test_umkm_slug_stays_the_same_when_name_is_unchanged(): void
    {
        $category = Category::factory()->create();
        $umkm = Umkm::factory()->for($category)->create(['name' => 'Sari Laut', 'slug' => 'slug-lama']);

        $this->actingAs(User::factory()->admin()->create())
            ->put(route('admin.umkms.update', $umkm), [
                ...$this->umkmPayload($category, 'Sari Laut'),
                'description' => 'Deskripsi baru',
            ])
            ->assertRedirect(route('admin.umkms.index'));

        $this->assertSame('slug-lama', $umkm->fresh()->slug);
    }

    public function test_umkm_slug_is_regenerated_when_name_changes(): void
    {
        $category = Category::factory()->create();
        $umkm = Umkm::factory()->for($category)->create(['name' => 'Sari Laut', 'slug' => 'sari-laut']);

        $this->actingAs(User::factory()->admin()->create())
            ->put(route('admin.umkms.update', $umkm), $this->umkmPayload($category, 'Sari Samudra'))
            ->assertRedirect(route('admin.umkms.index'));

        $this->assertSame('sari-samudra', $umkm->fresh()->slug);
    }

    public function test_umkm_name_without_letters_gets_a_fallback_slug(): void
    {
        $category = Category::factory()->create();

        $this->actingAs(User::factory()->admin()->create())
            ->post(route('admin.umkms.store'), $this->umkmPayload($category, '!!!'))
            ->assertRedirect(route('admin.umkms.index'));

        $this->assertSame('umkm', Umkm::first()->slug);
    }

    public function test_categories_with_colliding_slugs_do_not_crash(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->post(route('admin.categories.store'), ['name' => 'Makanan & Minuman']);
        $this->actingAs($admin)
            ->post(route('admin.categories.store'), ['name' => 'Makanan Minuman'])
            ->assertRedirect(route('admin.categories.index'));

        $this->assertSame(
            ['makanan-minuman', 'makanan-minuman-2'],
            Category::orderBy('id')->pluck('slug')->all(),
        );
    }

    public function test_deleting_umkm_also_deletes_cover_and_product_images(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('umkm/cover.jpg', 'x');
        Storage::disk('public')->put('products/a.jpg', 'x');

        $umkm = Umkm::factory()->create(['cover_image' => 'umkm/cover.jpg']);
        Product::factory()->for($umkm)->create(['image' => 'products/a.jpg']);
        Product::factory()->for($umkm)->create(['image' => null]);

        $this->actingAs(User::factory()->admin()->create())
            ->delete(route('admin.umkms.destroy', $umkm))
            ->assertRedirect(route('admin.umkms.index'));

        Storage::disk('public')->assertMissing('umkm/cover.jpg');
        Storage::disk('public')->assertMissing('products/a.jpg');
        $this->assertSame(0, Product::count());
    }

    public function test_admin_login_is_blocked_after_too_many_failed_attempts(): void
    {
        User::factory()->admin()->create(['email' => 'admin@example.com']);

        foreach (range(1, 5) as $attempt) {
            $this->post(route('admin.login.store'), ['email' => 'admin@example.com', 'password' => 'salah'])
                ->assertSessionHasErrors('email');
        }

        $this->post(route('admin.login.store'), ['email' => 'admin@example.com', 'password' => 'password'])
            ->assertSessionHasErrors('email');

        $this->assertStringContainsString(
            'Terlalu banyak percobaan',
            session('errors')->first('email'),
        );
        $this->assertGuest();
    }

    public function test_admin_can_login_with_correct_credentials(): void
    {
        User::factory()->admin()->create(['email' => 'admin@example.com']);

        $this->post(route('admin.login.store'), ['email' => 'admin@example.com', 'password' => 'password'])
            ->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticated();
    }

    public function test_make_admin_command_creates_an_admin_user(): void
    {
        $this->artisan('make:admin', ['--name' => 'Diva', '--email' => 'diva@example.com'])
            ->expectsQuestion('Password (minimal 8 karakter)', 'rahasia123')
            ->expectsQuestion('Ulangi password', 'rahasia123')
            ->assertSuccessful();

        $user = User::where('email', 'diva@example.com')->first();

        $this->assertTrue($user->is_admin);
        $this->assertNotSame('rahasia123', $user->password);
    }

    public function test_make_admin_command_rejects_short_or_mismatched_password(): void
    {
        $this->artisan('make:admin', ['--name' => 'Diva', '--email' => 'diva@example.com'])
            ->expectsQuestion('Password (minimal 8 karakter)', 'pendek')
            ->assertFailed();

        $this->artisan('make:admin', ['--name' => 'Diva', '--email' => 'diva@example.com'])
            ->expectsQuestion('Password (minimal 8 karakter)', 'rahasia123')
            ->expectsQuestion('Ulangi password', 'beda12345')
            ->assertFailed();

        $this->assertSame(0, User::count());
    }

    public function test_make_admin_command_promotes_an_existing_user(): void
    {
        $user = User::factory()->create(['email' => 'diva@example.com']);

        $this->artisan('make:admin', ['--name' => 'Diva', '--email' => 'diva@example.com'])
            ->assertSuccessful();

        $this->assertTrue($user->fresh()->is_admin);
    }
}
