<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Seed kategori UMKM.
     */
    public function run(): void
    {
        $names = [
            'Makanan & Minuman',
            'Sembako & Kelontong',
            'Jasa',
            'Kerajinan',
            'Fashion',
            'Perikanan',
            'Pertanian',
            'Lainnya',
        ];

        foreach ($names as $name) {
            Category::query()->updateOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name],
            );
        }
    }
}
