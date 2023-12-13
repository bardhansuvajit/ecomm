<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function orderProducts() {
        return $this->hasMany('App\Models\OrderProduct', 'order_id', 'id');
    }

    public function addressDetails() {
        return $this->hasOne('App\Models\OrderAddress', 'order_id', 'id');
    }

    public function couponDetails() {
        return $this->hasOne('App\Models\CouponUsage', 'order_id', 'id');
    }
}
