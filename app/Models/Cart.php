<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'product_variation_id',
        'save_for_later',
        'qty',
        'ip',
        'guest_token',
        'coupon_code'
    ];

    public function productDetails()
    {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }

    public function couponDetails()
    {
        return $this->belongsTo('App\Models\Coupon', 'coupon_code', 'id');
    }
}
