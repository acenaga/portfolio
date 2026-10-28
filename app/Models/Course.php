<?php

namespace App\Models;

use App\Enums\CourseLevel;
use App\Observers\PortfolioContentObserver;
use Database\Factories\CourseFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(PortfolioContentObserver::class)]
#[Fillable([
    'title',
    'tag',
    'level',
    'hours',
    'description',
    'sort',
    'is_published',
])]
class Course extends Model
{
    /** @use HasFactory<CourseFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'level' => CourseLevel::class,
            'is_published' => 'boolean',
        ];
    }

    /** @param Builder<Course> $query */
    public function scopePublished(Builder $query): void
    {
        $query->where('is_published', true)->orderBy('sort');
    }
}
