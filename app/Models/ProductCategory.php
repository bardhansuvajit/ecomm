<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    function productDetailsFrontend()
    {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id')->where('status', '!=', 2)->where('type', 1);
    }

    function productDetails()
    {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }

}
