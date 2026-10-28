<?php

namespace App\Models;

use App\Enums\VideoPlatform;
use App\Observers\PortfolioContentObserver;
use Database\Factories\VideoFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(PortfolioContentObserver::class)]
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
    'is_featured',
    'icon',
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
            'is_featured' => 'boolean',
            'published_at' => 'date',
            'is_published' => 'boolean',
        ];
    }

    /** Formato tipo YouTube: 4:12:34 para horas, 38:21 para minutos. */
    protected function durationFormatted(): Attribute
    {
        return Attribute::get(function (): ?string {
            if ($this->duration_seconds === null) {
                return null;
            }

            $h = intdiv($this->duration_seconds, 3600);
            $m = intdiv($this->duration_seconds % 3600, 60);
            $s = $this->duration_seconds % 60;

            return $h > 0
                ? sprintf('%d:%02d:%02d', $h, $m, $s)
                : sprintf('%d:%02d', $m, $s);
        });
    }

    /** @param Builder<Video> $query */
    public function scopePublished(Builder $query): void
    {
        $query->where('is_published', true)->orderBy('sort');
    }
}
