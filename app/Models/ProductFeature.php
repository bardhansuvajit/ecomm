<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductFeature extends Model
{
    use HasFactory;

    public function productDetail()
    {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }
}
