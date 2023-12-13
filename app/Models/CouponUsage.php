<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CouponUsage extends Model
{
    use HasFactory, SoftDeletes;

    public function orderDetails()
    {
        return $this->belongsTo('App\Models\Order', 'order_id', 'id');
    }
}
