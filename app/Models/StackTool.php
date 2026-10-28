<?php

namespace App\Models;

use Database\Factories\StackToolFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['stack_group_id', 'name', 'icon', 'sort'])]
class StackTool extends Model
{
    /** @use HasFactory<StackToolFactory> */
    use HasFactory;

    /** @return BelongsTo<StackGroup, $this> */
    public function group(): BelongsTo
    {
        return $this->belongsTo(StackGroup::class, 'stack_group_id');
    }
}
