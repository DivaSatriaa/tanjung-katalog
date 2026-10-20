<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\Models\Product;
use App\Models\Umkm;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SiteMetaTest extends TestCase
{
    use RefreshDatabase;

    public function test_sitemap_lists_only_public_content(): void
    {
        $product = Product::factory()->create(['slug' => 'produk-terbit']);
        Product::factory()->draft()->create(['slug' => 'produk-draf']);
        $post = Post::factory()->create(['slug' => 'berita-terbit']);
        Post::factory()->draft()->create(['slug' => 'berita-draf']);

        $this->get(route('sitemap'))
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml')
            ->assertSee(route('product.show', $product->slug), false)
            ->assertSee(route('umkm.show', $product->umkm->slug), false)
            ->assertSee(route('posts.show', $post->slug), false)
            ->assertDontSee('produk-draf')
            ->assertDontSee('berita-draf');
    }

    public function test_robots_txt_blocks_admin_and_points_to_sitemap(): void
    {
        $this->get('/robots.txt')
            ->assertOk()
            ->assertSee('Disallow: /admin')
            ->assertSee('Sitemap: '.route('sitemap'));
    }

    public function test_pages_have_social_meta_and_titles_are_not_double_escaped(): void
    {
        $category = Category::factory()->create(['name' => 'Makanan & Minuman', 'slug' => 'makanan-minuman']);
        Product::factory()->for(Umkm::factory()->for($category))->create();

        $this->get(route('product.index', ['category' => 'makanan-minuman']))
            ->assertOk()
            ->assertSee('<title>Makanan &amp; Minuman | TanjungKatalog</title>', false)
            ->assertDontSee('&amp;amp;', false)
            ->assertSee('<meta property="og:image"', false)
            ->assertSee('<link rel="canonical"', false);
    }

    public function test_missing_page_shows_indonesian_error_page(): void
    {
        $this->get('/halaman-yang-tidak-ada')
            ->assertNotFound()
            ->assertSee('Halaman tidak ditemukan');
    }

    public function test_umkm_catalog_ignores_array_query_values(): void
    {
        Umkm::factory()->create(['name' => 'Sari Laut']);

        $this->get(route('umkm.index', ['q' => ['x'], 'category' => ['y']]))
            ->assertOk()
            ->assertSee('Sari Laut');
    }

    public function test_other_category_is_listed_last(): void
    {
        foreach (['Lainnya', 'Fashion', 'Perikanan'] as $name) {
            Category::factory()->create(['name' => $name, 'slug' => strtolower($name)]);
        }

        $this->assertSame(
            ['Fashion', 'Perikanan', 'Lainnya'],
            Category::query()->ordered()->pluck('name')->all(),
        );
    }

    public function test_error_pages_render_without_built_assets(): void
    {
        foreach ([403, 404, 413, 419, 429, 500, 503] as $status) {
            $html = view('errors.'.$status)->render();

            $this->assertStringContainsString('TanjungKatalog', $html);
            $this->assertStringNotContainsString('/build/assets/', $html);
        }
    }
}
