<?php

namespace App\Models;

use Database\Factories\StackGroupFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['label', 'sort', 'is_published'])]
class StackGroup extends Model
{
    /** @use HasFactory<StackGroupFactory> */
    use HasFactory;

    /** @return HasMany<StackTool, $this> */
    public function tools(): HasMany
    {
        return $this->hasMany(StackTool::class)->orderBy('sort');
    }

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

    /** @param Builder<StackGroup> $query */
    public function scopePublishedWithTools(Builder $query): void
    {
        $query->where('is_published', true)
            ->orderBy('sort')
            ->with('tools');
    }
}
