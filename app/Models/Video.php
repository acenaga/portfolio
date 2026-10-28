<?php

namespace App\Models;

use App\Enums\VideoPlatform;
use Database\Factories\VideoFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'platform',
    'external_id',
    'title',
    'url',
    'thumbnail_url',
    'duration_seconds',
    'views',
    'is_live',
    'category',
    'published_at',
    'sort',
    'is_published',
])]
class Video extends Model
{
    /** @use HasFactory<VideoFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'platform' => VideoPlatform::class,
            'is_live' => 'boolean',
            'published_at' => 'date',
            'is_published' => 'boolean',
        ];
    }

    /** @param Builder<Video> $query */
    public function scopePublished(Builder $query): void
    {
        $query->where('is_published', true)->orderBy('sort');
    }
}
