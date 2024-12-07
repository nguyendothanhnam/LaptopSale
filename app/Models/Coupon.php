<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'coupon_name',
        'coupon_time',
        'coupon_code',
        'coupon_number',
        'coupon_condition',
    ];
    protected $primaryKey = 'coupon_id';
    protected $table = 'tbl_coupon';
}
