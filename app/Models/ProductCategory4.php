<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory4 extends Model
{
    use HasFactory;

    public function parentDetail()
    {
        return $this->belongsTo('App\Models\ProductCategory3', 'cat3_id', 'id');
    }

    function productsDetails()
    {
        return $this->hasMany('App\Models\ProductCategory', 'category_id', 'id')->where('level', 4);
    }
}
