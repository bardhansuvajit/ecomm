<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use HasFactory, SoftDeletes;

    public function couponUsageTotal()
    {
        return $this->hasMany('App\Models\CouponUsage', 'coupon_id', 'id');
    }

    public function couponDiscount()
    {
        return $this->hasMany('App\Models\CouponDiscount', 'coupon_id', 'id');
    }

    public function minimumCartAmount()
    {
        return $this->hasMany('App\Models\CouponMinimumCartAmount', 'coupon_id', 'id');
    }

    public function couponProducts()
    {
        return $this->hasMany('App\Models\CouponProduct', 'coupon_id', 'id');
    }

}
