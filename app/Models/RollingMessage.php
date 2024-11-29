<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class RollingMessage extends Model implements Sortable
{
    use HasFactory, SoftDeletes, SortableTrait, HasUuids;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rolling_messages';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The data type of the primary key.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'restaurant_id',

        'marquee_status',
        'active_marquee_no',
        'marquee_1',
        'marquee_2',
        'marquee_3',

        'holiday_marquee_status',
        'holiday_marquee',
        'holiday_marquee_start_date',
        'holiday_marquee_start_time',
        'holiday_marquee_end_date',
        'holiday_marquee_end_time',

        'order_column',

        'updated_by_user_id',
        'created_by_user_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'marquee_status' => 'boolean',
        'holiday_marquee_status' => 'boolean',
        'holiday_marquee_start_date' => 'date',
        'holiday_marquee_start_time' => 'datetime:H:i:s',
        'holiday_marquee_end_date' => 'date',
        'holiday_marquee_end_time' => 'datetime:H:i:s',
    ];

    /**
     * Configure sortable behavior.
     */
    public function buildSortQuery()
    {
        return static::query()->orderBy('order_column');
    }

    // Custom accessor for start datetime
    public function getStartDatetimeAttribute(): ?Carbon
    {
        if ($this->holiday_marquee_start_date && $this->holiday_marquee_start_time) {
            // Combine the date and time directly since they are already Carbon instances
            return $this->holiday_marquee_start_date
                ->setTimeFrom($this->holiday_marquee_start_time); // Use setTimeFrom for clean merging
        }
        return null;
    }

    // Custom accessor for end datetime
    public function getEndDatetimeAttribute(): ?Carbon
    {
        if ($this->holiday_marquee_end_date && $this->holiday_marquee_end_time) {
            // Combine the date and time directly since they are already Carbon instances
            return $this->holiday_marquee_end_date
                ->setTimeFrom($this->holiday_marquee_end_time); // Use setTimeFrom for clean merging
        }
        return null;
    }

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(related: User::class, foreignKey: 'created_by_user_id');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(related: User::class, foreignKey: 'updated_by_user_id');
    }
}
