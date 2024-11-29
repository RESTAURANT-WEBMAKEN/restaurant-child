<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialMedia extends Model
{
    // The table associated with the model
    protected $table = 'socmedia';
    protected $primaryKey = 'smid';

    // The attributes that are mass assignable
    protected $fillable = [
        'instagram',
        'facebook',
        'tripadvisor',
        'whatsapp',
        'youtube',
        'googlerev',
        'smedia1',
        'smedialink1',
        'smedia2',
        'smedialink2',
        'smedia3',
        'smedialink3',
        'smedia4',
        'smedialink4',
        'smedia5',
        'smedialink5',
        'smactiveyn',
    ];

    // Disable automatic timestamp management
    public $timestamps = false;
}
