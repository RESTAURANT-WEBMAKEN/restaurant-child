<?php

namespace App\Models;

use App\Enums\ColorThemeTypeEnum;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class ColorTheme extends Model implements Sortable
{
    use HasFactory, SoftDeletes, SortableTrait, HasUuids;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'color_themes';

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

        'name',

        'theme_1', 'theme_2', 'theme_3', 'theme_4',
        'light_1', 'light_2', 'light_3', 'light_4',
        'dark_1', 'dark_2', 'dark_3', 'dark_4',

        'marquee_1', 'marquee_2',

        'text_white', 'text_black',

        'bg_white', 'bg_black',

        'neutral_white',
        'neutral_black',
        'neutral_gray',
        'neutral_light_gray',
        'neutral_x_light_gray',
        'neutral_dark_gray',

        'active',
        'type',

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
        'active' => 'boolean',
        'type' => ColorThemeTypeEnum::class,
    ];

    /**
     * Configure sortable behavior.
     */
    public function buildSortQuery()
    {
        return static::query()->orderBy('order_column');
    }

    /**
     * Relationship with the restaurant.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    /**
     * Relationship with the user who created this theme.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(related: User::class, foreignKey: 'created_by_user_id');
    }

    /**
     * Relationship with the user who last updated this theme.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function updater(): BelongsTo
    {
        return $this->belongsTo(related: User::class, foreignKey: 'updated_by_user_id');
    }

    /**
     * Dynamic accessor for original and reversed color attributes.
     *
     * - Access `$model->key` to get the original color value.
     * - Access `$model->rkey` to get the reversed color using the helper function.
     *
     * @param string $key The attribute being accessed.
     * @return string|null The original or reversed color value.
     */
    public function __get($key)
    {
        // Check for "r" prefix (reversed color)
        if (str_starts_with($key, 'r')) {
            $originalKey = lcfirst(substr($key, 1)); // Remove "r" prefix to get the original key

            // Check if the original key exists in attributes
            if (array_key_exists($originalKey, $this->attributes) && $this->attributes[$originalKey]) {
                return invert_hex_color($this->attributes[$originalKey]);
            }

            return null; // Return null if original key doesn't exist or is null
        }

        // Default behavior: Return the original value for non-prefixed keys
        return parent::__get($key);
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function (self $colorTheme) {
            // If no records exist and the current record is being created with active = false,
            // throw an exception because the first record must have active = true.
            if (self::count() === 0 && !$colorTheme->active) {
                throw new \Exception('The first color theme must be active.');
            }

            // If the color theme already exists and we're trying to set active to false
            // while there is only one record in the table, throw an exception
            if ($colorTheme->exists && !$colorTheme->active && self::count() === 1) {
                throw new \Exception('Deactivation of the only color theme is not allowed. '
                    . 'There must be at least one active color theme in the system.');
            }

            // Deactivate all other themes when setting the current theme to active
            if ($colorTheme->active) {
                self::where('id', '!=', $colorTheme->id)->update(['active' => false]);
            }
        });

        static::deleting(function ($colorTheme) {
            // Prevent deletion if it’s the last row
            if (self::count() <= 1) {
                throw new \Exception('You cannot delete the last color theme.');
            }

            // If the theme being deleted is the active one, activate the first theme
            if ($colorTheme->active) {
                $firstTheme = self::first();
                if ($firstTheme) {
                    $firstTheme->update(['active' => true]);
                }
            }
        });

    }
}
