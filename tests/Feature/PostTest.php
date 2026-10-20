<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_news_index_lists_only_published_posts(): void
    {
        Post::factory()->create(['title' => 'Berita Terbit']);
        Post::factory()->draft()->create(['title' => 'Berita Draf']);
        Post::factory()->scheduled()->create(['title' => 'Berita Terjadwal']);

        $this->get(route('posts.index'))
            ->assertOk()
            ->assertSee('Berita Terbit')
            ->assertDontSee('Berita Draf')
            ->assertDontSee('Berita Terjadwal');
    }

    public function test_news_index_shows_empty_state(): void
    {
        $this->get(route('posts.index'))
            ->assertOk()
            ->assertSee('Belum ada berita');
    }

    public function test_published_post_can_be_read(): void
    {
        $post = Post::factory()->create([
            'title' => 'Bazar UMKM',
            'body' => "Paragraf pertama.\n\nParagraf kedua.",
        ]);

        $this->get(route('posts.show', $post->slug))
            ->assertOk()
            ->assertSee('Bazar UMKM')
            ->assertSee('Paragraf pertama.')
            ->assertSee('Paragraf kedua.')
            ->assertSee('<meta property="og:type" content="article">', false);
    }

    public function test_draft_and_scheduled_posts_return_404(): void
    {
        $draft = Post::factory()->draft()->create();
        $scheduled = Post::factory()->scheduled()->create();

        $this->get(route('posts.show', $draft->slug))->assertNotFound();
        $this->get(route('posts.show', $scheduled->slug))->assertNotFound();
    }

    public function test_post_body_html_is_escaped(): void
    {
        $post = Post::factory()->create(['body' => '<script>alert(1)</script>']);

        $this->get(route('posts.show', $post->slug))
            ->assertOk()
            ->assertDontSee('<script>alert(1)</script>', false)
            ->assertSee('&lt;script&gt;alert(1)&lt;/script&gt;', false);
    }

    public function test_homepage_shows_latest_news_section_only_when_posts_exist(): void
    {
        $this->get(route('home'))->assertOk()->assertDontSee('Berita Terbaru');

        Post::factory()->create(['title' => 'Kabar Terbaru Tanjung Mas']);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Berita Terbaru')
            ->assertSee('Kabar Terbaru Tanjung Mas');
    }
}
