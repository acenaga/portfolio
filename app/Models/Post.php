<?php

namespace App\Models;

use App\Observers\PortfolioContentObserver;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Espejo local de los posts publicados en la otra página (sync por API).
 * El contenido es de solo lectura: acá solo se curiona con is_visible.
 */
#[ObservedBy(PortfolioContentObserver::class)]
#[Fillable([
    'slug',
    'title',
    'excerpt',
    'url',
    'tags',
    'cover_url',
    'published_at',
    'is_visible',
    'fetched_at',
])]
class Post extends Model
{
    protected $table = 'posts';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tags' => 'array',
            'published_at' => 'date',
            'is_visible' => 'boolean',
            'fetched_at' => 'datetime',
        ];
    }

    /** @param Builder<Post> $query */
    public function scopeVisible(Builder $query): void
    {
        $query->where('is_visible', true)->orderByDesc('published_at');
    }
}
