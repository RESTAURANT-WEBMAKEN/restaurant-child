<?php

namespace App\Models;

use App\CentralLogics\Helpers;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Restaurant extends Model implements Sortable
{
    use HasFactory, HasUuids, SoftDeletes, SortableTrait;

    public $timestamps = true;

    protected $fillable = [
        'name',
        'description',
        'domain',
        'favicon',
        'logo',

        'installation_token',

        'featured',
        'visible',
        'verified',

        'status',
        'status_msg',
        'online_order_status',
        'online_order_msg',
        'reservation_status',
        'reservation_msg',
        'shutdown_status',
        'shutdown_msg',

        'order_column',

        'emails',
        'telephones',
        'addresses',

        'rolling_messages',
        'testimonials',
        'opening_hours',
        'meta_details',
        'social_links',
        'custom_social_links',
        'color_theme',
        'designs',
        'scripts',

        'timezone',

        'geo_location_link',

        'other_details',

        'updated_by_user_id',
        'created_by_user_id',
    ];

    protected $casts = [
        'featured' => 'boolean',
        'visible' => 'boolean',
        'verified' => 'boolean',

        'status' => 'boolean',
        'online_order_status' => 'boolean',
        'reservation_status' => 'boolean',
        'shutdown_status' => 'boolean',

        'order_column' => 'integer',

        'emails' => 'array',
        'telephones' => 'array',
        'addresses' => 'array',

        'rolling_messages' => 'array',
        'testimonials' => 'array',
        'opening_hours' => 'array',
        'meta_details' => 'array',
        'social_links' => 'array',
        'custom_social_links' => 'array',
        'color_theme' => 'array',
        'designs' => 'array',
        'scripts' => 'array',

        'other_details' => 'array',
    ];

    protected $appends = [
        'favicon_full_url',
        'logo_full_url',
    ];

    public function getLogoFullUrlAttribute()
    {
        $value = $this->logo;
        return Helpers::get_img_full_url(null, $value, 'public', 'logo');
    }
    public function getFaviconFullUrlAttribute()
    {
        $value = $this->favicon;
        return Helpers::get_img_full_url(null, $value, 'public', 'favicon');
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
