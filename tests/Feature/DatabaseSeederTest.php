<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\Models\Product;
use App\Models\Umkm;
use App\Models\User;
use Database\Seeders\UmkmSeeder;
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

        $this->app->bind(UmkmSeeder::class, fn () => new UmkmSeeder(base_path('tests/Fixtures/umkm')));
    }

    public function test_seeder_imports_every_umkm_from_kelurahan_spreadsheet(): void
    {
        $this->seed();

        $this->assertSame(8, Category::count());
        $this->assertSame(4, Umkm::count());
        $this->assertSame(0, Umkm::where('status', '!=', 'published')->count());
        $this->assertSame(0, Umkm::whereNull('category_id')->count());
        $this->assertDatabaseMissing('umkms', ['name' => 'Contoh Usaha']);
    }

    public function test_seeder_normalizes_names_phone_numbers_and_addresses(): void
    {
        $this->seed();

        $warung = Umkm::where('name', 'Warung Makan Bu Contoh')->firstOrFail();
        $this->assertSame('Siti Contoh', $warung->owner_name);
        $this->assertSame('081200000001', $warung->whatsapp);
        $this->assertSame('Jl. Contoh No. 1 RT 02 RW 01, Tanjung Mas, Semarang Utara', $warung->address);
        $this->assertSame('makanan-minuman', $warung->category->slug);

        $laundry = Umkm::where('name', 'Laundry Kilat Contoh')->firstOrFail();
        $this->assertSame('Budi Contoh', $laundry->owner_name);
        $this->assertSame('081200000002', $laundry->whatsapp);
        $this->assertSame('jasa', $laundry->category->slug);

        $unnamed = Umkm::where('name', 'Usaha Sri Contoh')->firstOrFail();
        $this->assertNull($unnamed->whatsapp);
        $this->assertSame('0243500000', $unnamed->phone);
        $this->assertSame('RW 01, Tanjung Mas, Semarang Utara', $unnamed->address);
        $this->assertSame('sembako-kelontong', $unnamed->category->slug);

        $this->assertSame('perikanan', Umkm::where('name', 'Ikan Asin Contoh')->firstOrFail()->category->slug);
    }

    public function test_seeder_creates_a_product_from_each_product_type(): void
    {
        $this->seed();

        $product = Product::where('name', 'Nasi Rames')->firstOrFail();

        $this->assertSame('Warung Makan Bu Contoh', $product->umkm->name);
        $this->assertNull($product->price);
        $this->assertSame(Umkm::count(), Product::count());
    }

    public function test_seeder_can_run_more_than_once_without_duplicates(): void
    {
        $this->seed();

        $counts = [Category::count(), Umkm::count(), Product::count(), Post::count(), User::count()];

        $this->seed();

        $this->assertSame($counts, [Category::count(), Umkm::count(), Product::count(), Post::count(), User::count()]);
    }

    public function test_reseeding_keeps_changes_made_from_admin_panel(): void
    {
        $this->seed();

        $umkm = Umkm::where('name', 'Ikan Asin Contoh')->firstOrFail();
        $umkm->update(['whatsapp' => '081299999999', 'description' => 'Diperbarui admin']);

        $this->seed();

        $this->assertSame('081299999999', $umkm->fresh()->whatsapp);
        $this->assertSame('Diperbarui admin', $umkm->fresh()->description);
    }

    public function test_seeder_removes_previous_fictional_demo_data(): void
    {
        $demoUmkm = Umkm::factory()->create(['slug' => 'sari-laut']);
        Product::factory()->for($demoUmkm)->create();
        Post::factory()->create(['slug' => 'bazar-produk-olahan-ikan-ramaikan-kampung-bahari']);

        $this->seed();

        $this->assertDatabaseMissing('umkms', ['slug' => 'sari-laut']);
        $this->assertDatabaseMissing('posts', ['slug' => 'bazar-produk-olahan-ikan-ramaikan-kampung-bahari']);
    }

    public function test_seeder_skips_umkm_import_when_spreadsheet_is_missing(): void
    {
        $this->app->bind(UmkmSeeder::class, fn () => new UmkmSeeder(base_path('tests/Fixtures/tidak-ada')));

        $this->seed();

        $this->assertSame(0, Umkm::count());
        $this->assertSame(9, Post::count());
    }

    public function test_seeder_imports_kelurahan_umkm_news_with_cover_photos(): void
    {
        $this->seed();

        $this->assertSame(9, Post::published()->count());

        foreach (Post::pluck('cover_image') as $path) {
            $this->assertNotNull($path);
            Storage::disk('public')->assertExists($path);
        }

        $this->assertStringContainsString(
            'tanjungmas.semarangkota.go.id/umkm/geraiumkmkelurahantanjungmas',
            Post::where('slug', 'gerai-umkm-kelurahan-tanjung-mas')->firstOrFail()->body,
        );
    }

    public function test_public_pages_render_with_seeded_data(): void
    {
        $this->seed();

        $this->get(route('home'))->assertOk()->assertSee('Warung Makan Bu Contoh');
        $this->get(route('product.index', ['q' => 'Nasi']))->assertOk()->assertSee('Nasi Rames');
        $this->get(route('umkm.index'))
            ->assertOk()
            ->assertSee('Laundry Kilat Contoh')
            ->assertSee('data-icon="jasa"', false);
        $this->get(route('peta.index'))->assertOk();
        $this->get(route('posts.index'))->assertOk()->assertSee('Gerai UMKM Kelurahan Tanjung Mas');
    }

    public function test_product_without_price_asks_buyer_to_contact_seller(): void
    {
        $this->seed();

        $product = Product::where('name', 'Nasi Rames')->firstOrFail();

        $this->get(route('product.show', $product->slug))
            ->assertOk()
            ->assertSee('Harga dapat ditanyakan ke penjual');
    }
}
