<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserve extends Model
{
    // The table associated with the model
    protected $table = 'reserve';
    protected $primaryKey = 'id';

    // The attributes that are mass assignable
    protected $fillable = [
        'nameyn',
        'emailyn',
        'telyn',
        'addressyn',
        'email1',
        'email2',
        'email3',
        'email4',
        'email5',
        'linkresv',
        'mailself',
        'mailcust',
        'timeinterval',
        'maildelay',
        'reserve',
        'content',
        'closemsg',
        'succmsg',
    ];

    // Disable automatic timestamp management
    public $timestamps = false;
}
