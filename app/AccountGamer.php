<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountGamer extends Model
{
    public $table = 'account';
    protected $connection = 'DATABASE_GAME';
    public $timestamps = false;
    public $primaryKey = 'act_id';


    public $fillable = [
        'act_id',
        'act_name',
        'gm',
        'cha_ids',
        'last_ip',
        'disc_reason',
        'last_leave',
        'password',
        'merge_state',
        'mall_points',
        'credits',
        'vote_time',
        'vote_time1',
        'vote_time2',
        'total_votes'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'act_id' => 'integer',
        'act_name' => 'string',
        'cha_ids' => 'string',
        'last_ip' => 'string',
        'disc_reason' => 'string',
        'password' => 'string',
        'merge_state' => 'integer',
        'mall_points' => 'integer',
        'credits' => 'integer',
        'vote_time' => 'string',
        'vote_time1' => 'string',
        'vote_time2' => 'string',
        'total_votes' => 'integer'
    ];
}