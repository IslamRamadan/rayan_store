<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCoupon extends Model
{
    protected $table = 'user_coupons';
    public $timestamps = true;
    protected $fillable = array('user_id', 'coupon_id');



}
