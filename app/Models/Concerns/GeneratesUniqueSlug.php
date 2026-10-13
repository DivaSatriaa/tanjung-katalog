<?php

namespace App\Models\Concerns;

use Illuminate\Support\Str;

trait GeneratesUniqueSlug
{
    /**
     * Buat slug dari nama dan tambahkan akhiran angka bila sudah dipakai.
     */
    public static function uniqueSlugFor(string $name, ?self $except = null, string $fallback = 'item'): string
    {
        $base = Str::slug($name) ?: $fallback;
        $slug = $base;
        $suffix = 2;

        while (
            static::query()
                ->where('slug', $slug)
                ->when($except, fn ($query) => $query->whereKeyNot($except->getKey()))
                ->exists()
        ) {
            $slug = $base.'-'.$suffix;
            $suffix++;
        }

        return $slug;
    }
}
