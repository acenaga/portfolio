<?php

namespace App\Models;

use App\Observers\PortfolioContentObserver;
use Database\Factories\SiteStatFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(PortfolioContentObserver::class)]
#[Fillable(['value', 'label', 'sort', 'is_published'])]
class SiteStat extends Model
{
    /** @use HasFactory<SiteStatFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }

    /** @param Builder<SiteStat> $query */
    public function scopePublished(Builder $query): void
    {
        $query->where('is_published', true)->orderBy('sort');
    }
}
