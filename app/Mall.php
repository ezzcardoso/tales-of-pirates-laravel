<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mall extends Model
{
    public $table = 'itemMall';
    protected $connection = 'DATABASE_AUCTION';
    public $timestamps = false;
    public $primaryKey = 'MallID';

    protected $fillable = ['ItemName', 'ItemPrice', 'ItemDesc', 'Quota', 'Icon', 'cType', 'ItemID', 'quantity', 'category'];

    static public function subtract_value(int $mall_points, int $ItemPrice)
    {


        return ($mall_points - $ItemPrice);
    }
}
