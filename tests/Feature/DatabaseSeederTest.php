<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Umkm;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DatabaseSeederTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    public function test_seeder_creates_published_sample_data(): void
    {
        $this->seed();

        $this->assertSame(6, Category::count());
        $this->assertSame(13, Umkm::count());
        $this->assertSame(Product::count(), Product::where('status', 'published')->count());
        $this->assertSame(0, Umkm::whereNull('latitude')->orWhereNull('longitude')->count());
        $this->assertSame(0, Umkm::whereNull('category_id')->count());
    }

    public function test_seeder_attaches_demo_photos_to_every_umkm_product_and_post(): void
    {
        $this->seed();

        $paths = [
            ...Umkm::pluck('cover_image'),
            ...Product::pluck('image'),
            ...Post::pluck('cover_image'),
            ...ProductImage::pluck('path'),
        ];

        $this->assertNotContains(null, $paths);
        $this->assertGreaterThan(0, ProductImage::count());

        foreach ($paths as $path) {
            Storage::disk('public')->assertExists($path);
        }
    }

    public function test_seeder_can_run_more_than_once_without_duplicates(): void
    {
        $this->seed();

        $counts = [Category::count(), Umkm::count(), Product::count(), ProductImage::count(), User::count()];

        $this->seed();

        $this->assertSame($counts, [Category::count(), Umkm::count(), Product::count(), ProductImage::count(), User::count()]);
    }

    public function test_public_pages_render_with_seeded_data(): void
    {
        $this->seed();

        $this->get(route('home'))->assertOk()->assertSee('Sari Laut');
        $this->get(route('product.index', ['q' => 'Bandeng']))->assertOk()->assertSee('Bandeng Presto');
        $this->get(route('umkm.index'))->assertOk()->assertSee('Batik Mas Jaya')->assertSee('storage/umkm/batik-mas-jaya.jpg');
        $this->get(route('peta.index'))->assertOk()->assertSee('Nelayan Mandiri');
        $this->get(route('product.show', 'kerupuk-ikan'))->assertOk()->assertSee('Rp15.000', false);
    }

    public function test_product_without_price_asks_buyer_to_contact_seller(): void
    {
        $this->seed();

        $this->get(route('product.show', 'cuci-selimut-dan-bed-cover'))
            ->assertOk()
            ->assertSee('Harga dapat ditanyakan ke penjual');
    }
}
