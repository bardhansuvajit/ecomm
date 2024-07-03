<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    public function productDetails()
    {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }

    public function couponDetails()
    {
        return $this->belongsTo('App\Models\Coupon', 'coupon_code', 'id');
    }

    public function variationDetail()
    {
        return $this->belongsTo('App\Models\ProductVariationChild', 'variation_child_id', 'id');
    }
}
