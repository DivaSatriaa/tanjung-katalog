<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class CategoryIconTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return array<string, array{string, string}>
     */
    public static function categorySlugs(): array
    {
        return [
            'makanan & minuman' => ['makanan-minuman', 'makanan'],
            'minuman' => ['minuman', 'minuman'],
            'kerajinan' => ['kerajinan-tangan', 'kerajinan'],
            'fashion' => ['fashion', 'fashion'],
            'perikanan' => ['perikanan', 'perikanan'],
            'pertanian' => ['pertanian', 'pertanian'],
            'jasa' => ['jasa', 'jasa'],
            'lainnya' => ['lainnya', 'lainnya'],
            'tidak dikenal' => ['otomotif', 'default'],
        ];
    }

    #[DataProvider('categorySlugs')]
    public function test_category_icon_is_chosen_from_category_slug(string $slug, string $expectedIcon): void
    {
        $category = Category::factory()->make(['slug' => $slug]);

        $this->blade('<x-category-icon :category="$category" />', ['category' => $category])
            ->assertSee('data-icon="'.$expectedIcon.'"', false);
    }

    public function test_homepage_shows_svg_icon_for_each_category(): void
    {
        Category::factory()->create(['name' => 'Perikanan', 'slug' => 'perikanan']);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('data-icon="perikanan"', false);
    }
}
