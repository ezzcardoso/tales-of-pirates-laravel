<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatLog extends Model
{
    public $table = 'stat_log';
    protected $connection = 'DATABASE_GAME';


    public $fillable = [
        'login_num',
        'play_num',
        'wgplay_num'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'login_num' => 'integer',
        'play_num' => 'integer',
        'wgplay_num' => 'integer'
    ];
}
