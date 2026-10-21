<?php

namespace Database\Seeders\Concerns;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

trait SeedsImages
{
    /**
     * Salin foto contoh dari database/seeders/images ke disk "public".
     *
     * Mengembalikan path relatif yang siap disimpan ke kolom gambar,
     * atau null bila foto contoh tidak tersedia.
     */
    protected function seedImage(string $path): ?string
    {
        $source = database_path('seeders/images/'.$path);

        if (! File::isFile($source)) {
            return null;
        }

        $disk = Storage::disk('public');

        if (! $disk->exists($path)) {
            $disk->put($path, File::get($source));
        }

        return $path;
    }

    /**
     * Foto galeri tambahan berpola "{prefix}-1.jpg", "{prefix}-2.jpg", dan seterusnya.
     *
     * @return array<int, string>
     */
    protected function seedGalleryImages(string $prefix): array
    {
        $paths = [];

        for ($index = 1; $path = $this->seedImage("{$prefix}-{$index}.jpg"); $index++) {
            $paths[] = $path;
        }

        return $paths;
    }
}
