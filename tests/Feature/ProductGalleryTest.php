<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductGalleryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return array<string, mixed>
     */
    private function payload(Product $product, array $overrides = []): array
    {
        return [
            'umkm_id' => $product->umkm_id,
            'name' => $product->name,
            'status' => 'published',
            ...$overrides,
        ];
    }

    public function test_admin_can_upload_gallery_images(): void
    {
        Storage::fake('public');
        $product = Product::factory()->create();

        $this->actingAs(User::factory()->admin()->create())
            ->put(route('admin.products.update', $product), $this->payload($product, [
                'gallery' => [
                    UploadedFile::fake()->image('a.jpg'),
                    UploadedFile::fake()->image('b.png'),
                ],
            ]))
            ->assertRedirect(route('admin.products.index'));

        $this->assertSame(2, $product->images()->count());
        $product->images->each(fn (ProductImage $image) => Storage::disk('public')->assertExists($image->path));
    }

    public function test_gallery_is_limited_to_eight_images(): void
    {
        Storage::fake('public');
        $product = Product::factory()->create();
        ProductImage::factory()->count(7)->for($product)->create();

        $this->actingAs(User::factory()->admin()->create())
            ->put(route('admin.products.update', $product), $this->payload($product, [
                'gallery' => [
                    UploadedFile::fake()->image('a.jpg'),
                    UploadedFile::fake()->image('b.jpg'),
                ],
            ]))
            ->assertRedirect(route('admin.products.edit', $product))
            ->assertSessionHas('error');

        $this->assertSame(8, $product->images()->count());
    }

    public function test_admin_can_remove_only_images_of_the_edited_product(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('products/gallery/milik.jpg', 'x');
        Storage::disk('public')->put('products/gallery/lain.jpg', 'x');

        $product = Product::factory()->create();
        $ownImage = ProductImage::factory()->for($product)->create(['path' => 'products/gallery/milik.jpg']);
        $otherImage = ProductImage::factory()->create(['path' => 'products/gallery/lain.jpg']);

        $this->actingAs(User::factory()->admin()->create())
            ->put(route('admin.products.update', $product), $this->payload($product, [
                'remove_gallery' => [$ownImage->id, $otherImage->id],
            ]));

        $this->assertModelMissing($ownImage);
        $this->assertModelExists($otherImage);
        Storage::disk('public')->assertMissing('products/gallery/milik.jpg');
        Storage::disk('public')->assertExists('products/gallery/lain.jpg');
    }

    public function test_deleting_product_removes_gallery_files(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('products/gallery/a.jpg', 'x');
        $product = Product::factory()->create();
        ProductImage::factory()->for($product)->create(['path' => 'products/gallery/a.jpg']);

        $this->actingAs(User::factory()->admin()->create())
            ->delete(route('admin.products.destroy', $product));

        Storage::disk('public')->assertMissing('products/gallery/a.jpg');
        $this->assertSame(0, ProductImage::count());
    }

    public function test_product_page_shows_gallery_thumbnails(): void
    {
        $product = Product::factory()->create(['image' => 'products/utama.jpg']);
        ProductImage::factory()->for($product)->create(['path' => 'products/gallery/kedua.jpg']);

        $this->get(route('product.show', $product->slug))
            ->assertOk()
            ->assertSee('data-gallery-thumb', false)
            ->assertSee('products/gallery/kedua.jpg', false);
    }

    public function test_product_page_without_extra_photos_has_no_thumbnails(): void
    {
        $product = Product::factory()->create(['image' => 'products/utama.jpg']);

        $this->get(route('product.show', $product->slug))
            ->assertOk()
            ->assertDontSee('data-gallery-thumb', false);
    }
}
