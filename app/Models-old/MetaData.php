<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetaData extends Model
{
    // The table associated with the model
    protected $table = 'metadata';
    protected $primaryKey = 'id';

    // The attributes that are mass assignable
    protected $fillable = [
        'mainpg',
        'pgtitle',
        'pgdesc',
        'pgkeyword',
        'review',
        'revtitle',
        'revdesc',
        'revkeyword',
        'reserveyn',
        'reserv',
        'restitle',
        'resdesc',
        'reskeyword',
        'menuyn',
        'menupg',
        'mentitle',
        'mendesc',
        'menkeyword',
        'tmenupg',
        'tmentitle',
        'tmendesc',
        'tmenkeyword',
        'takeyn',
        'orderyn',
        'orderpg',
        'ordtitle',
        'orddesc',
        'ordkeyword',
    ];

    // Disable automatic timestamp management
    public $timestamps = false;
}
