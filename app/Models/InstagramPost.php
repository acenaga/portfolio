<?php

namespace App\Models;

use App\Observers\PortfolioContentObserver;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Espejo local de los posts de Instagram via Instagram Graph API.
 * Solo lectura: acá se curiona con is_visible.
 */
#[ObservedBy(PortfolioContentObserver::class)]
#[Fillable([
    'external_id',
    'media_type',
    'caption',
    'media_url',
    'thumbnail_url',
    'permalink',
    'like_count',
    'comments_count',
    'published_at',
    'is_visible',
    'fetched_at',
])]
class InstagramPost extends Model
{
    protected $table = 'instagram_posts';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'like_count' => 'integer',
            'comments_count' => 'integer',
            'published_at' => 'datetime',
            'is_visible' => 'boolean',
            'fetched_at' => 'datetime',
        ];
    }

    public function isVideo(): bool
    {
        return $this->media_type === 'VIDEO';
    }

    public function isCarousel(): bool
    {
        return $this->media_type === 'CAROUSEL_ALBUM';
    }

    /** @param Builder<InstagramPost> $query */
    public function scopeVisible(Builder $query): void
    {
        $query->where('is_visible', true)->orderByDesc('published_at');
    }
}
