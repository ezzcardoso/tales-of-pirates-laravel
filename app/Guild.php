<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guild extends Model
{
    public $table = 'guild';
    protected $connection = 'DATABASE_GAME';
    public $timestamps = false;


    public $fillable = [
        'guild_name',
        'motto',
        'passwd',
        'leader_id',
        'type',
        'stat',
        'money',
        'exp',
        'member_total',
        'try_total',
        'disband_date',
        'challlevel',
        'challid',
        'challmoney',
        'challstart'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'guild_id' => 'integer',
        'guild_name' => 'string',
        'motto' => 'string',
        'passwd' => 'string',
        'leader_id' => 'integer',
        'challid' => 'integer'
    ];
}