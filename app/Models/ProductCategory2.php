<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory2 extends Model
{
    use HasFactory;

    public function parentDetail()
    {
        return $this->belongsTo('App\Models\ProductCategory1', 'cat1_id', 'id');
    }

    function productsDetails()
    {
        return $this->hasMany('App\Models\ProductCategory', 'category_id', 'id')->where('level', 2);
    }
}
