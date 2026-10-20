<?php

namespace App\Models;

use App\Models\Concerns\GeneratesUniqueSlug;
use Database\Factories\PostFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    /** @use HasFactory<PostFactory> */
    use GeneratesUniqueSlug, HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'body',
        'cover_image',
        'status',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    /**
     * Berita terbit yang tanggal terbitnya sudah lewat.
     *
     * @param  Builder<Post>  $query
     * @return Builder<Post>
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    /**
     * Ringkasan untuk kartu dan meta description.
     */
    public function summary(int $limit = 160): string
    {
        $text = $this->excerpt ?: $this->body;

        return Str::limit(trim(preg_replace('/\s+/', ' ', (string) $text)), $limit);
    }

    public function isPublished(): bool
    {
        return $this->status === 'published'
            && $this->published_at !== null
            && $this->published_at->lte(now());
    }
}
