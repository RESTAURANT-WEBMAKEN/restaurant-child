<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Reservation extends Model implements Sortable
{
    use HasFactory, HasUuids, SoftDeletes, SortableTrait;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'date',
        'time',
        'persons',
        'comments',

        'order_column',

    ];

    protected $casts = [
        'date' => 'date',
        'time' => 'datetime:H:i:s', // Cast as datetime with a custom format
        'persons' => 'integer',
        'order_column' => 'integer',
    ];

}
