<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpeningHour extends Model
{
    // The table associated with the model
    protected $table = 'gparam';
    protected $primaryKey = 'id';

    // The attributes that are mass assignable
    protected $fillable = [
        'day1',
        'stime11',
        'etime11',
        'stime12',
        'etime12',
        'holiday1',

        'day2',
        'stime21',
        'etime21',
        'stime22',
        'etime22',
        'holiday2',

        'day3',
        'stime31',
        'etime31',
        'stime32',
        'etime32',
        'holiday3',

        'day4',
        'stime41',
        'etime41',
        'stime42',
        'etime42',
        'holiday4',

        'day5',
        'stime51',
        'etime51',
        'stime52',
        'etime52',
        'holiday5',

        'day6',
        'stime61',
        'etime61',
        'stime62',
        'etime62',
        'holiday6',

        'day7',
        'stime71',
        'etime71',
        'stime72',
        'etime72',
        'holiday7',

        'messg',
        'content',
    ];

    // Disable automatic timestamp management
    public $timestamps = false;

    public $casts = [
        'stime11' => 'datetime:H:i:s',
        'etime11' => 'datetime:H:i:s',
        'stime12' => 'datetime:H:i:s',
        'etime12' => 'datetime:H:i:s',

        'stime21' => 'datetime:H:i:s',
        'etime21' => 'datetime:H:i:s',
        'stime22' => 'datetime:H:i:s',
        'etime22' => 'datetime:H:i:s',

        'stime31' => 'datetime:H:i:s',
        'etime31' => 'datetime:H:i:s',
        'stime32' => 'datetime:H:i:s',
        'etime32' => 'datetime:H:i:s',

        'stime41' => 'datetime:H:i:s',
        'etime41' => 'datetime:H:i:s',
        'stime42' => 'datetime:H:i:s',
        'etime42' => 'datetime:H:i:s',

        'stime51' => 'datetime:H:i:s',
        'etime51' => 'datetime:H:i:s',
        'stime52' => 'datetime:H:i:s',
        'etime52' => 'datetime:H:i:s',

        'stime61' => 'datetime:H:i:s',
        'etime61' => 'datetime:H:i:s',
        'stime62' => 'datetime:H:i:s',
        'etime62' => 'datetime:H:i:s',

        'stime71' => 'datetime:H:i:s',
        'etime71' => 'datetime:H:i:s',
        'stime72' => 'datetime:H:i:s',
        'etime72' => 'datetime:H:i:s',

    ];
}
