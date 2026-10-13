<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Umkm;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Umkm>
 */
class UmkmFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->company();

        return [
            'category_id' => Category::factory(),
            'name' => $name,
            'slug' => Str::slug($name),
            'owner_name' => fake()->name(),
            'description' => fake()->sentence(),
            'address' => fake()->address(),
            'whatsapp' => '081234567890',
            'is_featured' => false,
            'status' => 'published',
        ];
    }

    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'draft',
        ]);
    }
}
