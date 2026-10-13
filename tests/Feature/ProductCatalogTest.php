<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\Umkm;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductCatalogTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_catalog_lists_only_published_products_of_published_umkms(): void
    {
        $umkm = Umkm::factory()->create();
        Product::factory()->for($umkm)->create(['name' => 'Kerupuk Ikan']);
        Product::factory()->for($umkm)->draft()->create(['name' => 'Produk Draft']);
        Product::factory()
            ->for(Umkm::factory()->draft())
            ->create(['name' => 'Produk UMKM Draft']);

        $this->get(route('product.index'))
            ->assertOk()
            ->assertSee('Kerupuk Ikan')
            ->assertDontSee('Produk Draft')
            ->assertDontSee('Produk UMKM Draft');
    }

    public function test_product_catalog_can_be_filtered_by_category(): void
    {
        $food = Category::factory()->create(['name' => 'Makanan', 'slug' => 'makanan']);
        $craft = Category::factory()->create(['name' => 'Kerajinan', 'slug' => 'kerajinan']);

        Product::factory()
            ->for(Umkm::factory()->for($food))
            ->create(['name' => 'Abon Ikan']);
        Product::factory()
            ->for(Umkm::factory()->for($craft))
            ->create(['name' => 'Tas Anyaman']);

        $this->get(route('product.index', ['category' => 'makanan']))
            ->assertOk()
            ->assertSee('Abon Ikan')
            ->assertDontSee('Tas Anyaman');
    }

    public function test_product_catalog_can_be_searched_by_product_or_umkm_name(): void
    {
        Product::factory()
            ->for(Umkm::factory()->create(['name' => 'Sari Laut']))
            ->create(['name' => 'Bandeng Presto', 'description' => 'Ikan segar']);
        Product::factory()
            ->for(Umkm::factory()->create(['name' => 'Griya Anyam']))
            ->create(['name' => 'Tas Anyaman', 'description' => 'Bahan rotan']);

        $this->get(route('product.index', ['q' => 'Bandeng']))
            ->assertOk()
            ->assertSee('Bandeng Presto')
            ->assertDontSee('Tas Anyaman');

        $this->get(route('product.index', ['q' => 'Griya']))
            ->assertOk()
            ->assertSee('Tas Anyaman')
            ->assertDontSee('Bandeng Presto');
    }

    public function test_product_catalog_can_be_sorted_by_price(): void
    {
        Product::factory()->create(['name' => 'Produk Mahal', 'price' => 50000]);
        Product::factory()->create(['name' => 'Produk Murah', 'price' => 5000]);
        Product::factory()->create(['name' => 'Produk Tanpa Harga', 'price' => null]);

        $this->get(route('product.index', ['sort' => 'termurah']))
            ->assertOk()
            ->assertSeeInOrder(['Produk Murah', 'Produk Mahal', 'Produk Tanpa Harga']);

        $this->get(route('product.index', ['sort' => 'termahal']))
            ->assertOk()
            ->assertSeeInOrder(['Produk Mahal', 'Produk Murah', 'Produk Tanpa Harga']);
    }

    public function test_product_catalog_ignores_invalid_query_values(): void
    {
        Product::factory()->create(['name' => 'Kerupuk Ikan']);

        $this->get(route('product.index', ['sort' => 'asal', 'category' => ['x']]))
            ->assertOk()
            ->assertSee('Kerupuk Ikan');
    }

    public function test_product_catalog_shows_empty_state_when_nothing_matches(): void
    {
        $this->get(route('product.index', ['q' => 'tidak-ada']))
            ->assertOk()
            ->assertSee('Produk tidak ditemukan');
    }

    public function test_category_sidebar_counts_only_published_products(): void
    {
        $category = Category::factory()->create(['name' => 'Makanan', 'slug' => 'makanan']);
        $umkm = Umkm::factory()->for($category)->create();
        Product::factory()->count(2)->for($umkm)->create();
        Product::factory()->for($umkm)->draft()->create();

        $this->get(route('product.index'))
            ->assertOk()
            ->assertViewHas('totalProducts', 2)
            ->assertViewHas(
                'categories',
                fn ($categories) => $categories->first()->products_count === 2,
            );
    }
}
