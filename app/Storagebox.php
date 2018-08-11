<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Storagebox extends Model
{
    public $table = 'StorageBox';
    protected $connection = 'DATABASE_AUCTION';
    public $timestamps = false;
    public $primaryKey = 'act_id';
    protected $fillable = ['act_id', 'item_id', 'assigned', 'assigned_char', 'assigned_date', 'Icon', 'ItemMall', 'quantity', 'storage_id'];

}
