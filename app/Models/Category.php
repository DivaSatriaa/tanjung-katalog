<?php

namespace App\Models;

use App\Models\Concerns\GeneratesUniqueSlug;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Category extends Model
{
    use GeneratesUniqueSlug, HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    public function umkms(): HasMany
    {
        return $this->hasMany(Umkm::class);
    }

    public function products(): HasManyThrough
    {
        return $this->hasManyThrough(Product::class, Umkm::class);
    }

    /**
     * Urutkan berdasarkan nama dengan kategori "Lainnya" selalu di akhir.
     *
     * @param  Builder<Category>  $query
     * @return Builder<Category>
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query
            ->orderByRaw("CASE WHEN slug = 'lainnya' THEN 1 ELSE 0 END")
            ->orderBy('name');
    }
}
