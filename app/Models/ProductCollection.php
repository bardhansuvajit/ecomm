<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCollection extends Model
{
    use HasFactory;

    function productDetails()
    {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }
}
