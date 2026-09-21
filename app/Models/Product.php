<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'umkm_id',
        'name',
        'slug',
        'description',
        'price',
        'image',
        'is_featured',
        'status',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function umkm(): BelongsTo
    {
        return $this->belongsTo(Umkm::class);
    }
}