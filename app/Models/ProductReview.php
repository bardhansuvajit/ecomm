<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductReview extends Model
{
    use HasFactory, SoftDeletes;

    public function productDetails()
    {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }

    public function userDetails()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
