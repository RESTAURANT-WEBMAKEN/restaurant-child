<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\EloquentSortable\SortableTrait;

class PageEdit extends Model
{
    use HasFactory, HasUuids, SoftDeletes, SortableTrait;

    protected $fillable = [
        'key',
        'value',
        'comments',

        'status',

        'order_column',

        'updated_by_user_id',
        'created_by_user_id',
    ];

    protected $casts = [
        'value' => 'array',
        'status' => 'boolean',
        'order_column' => 'integer',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(related: User::class, foreignKey: 'created_by_user_id');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(related: User::class, foreignKey: 'updated_by_user_id');
    }
}
