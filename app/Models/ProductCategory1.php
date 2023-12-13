<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory1 extends Model
{
    use HasFactory;

    function productsDetails()
    {
        return $this->hasMany('App\Models\ProductCategory', 'category_id', 'id')->where('level', 1);
    }

    // function categoryHighlights()
    // {
    //     return $this->hasMany('App\Models\ProductCategory1Highlight', 'category_id', 'id');
    // }

    // function categoryHighlightsFront()
    // {
    //     return $this->hasMany('App\Models\ProductCategory1Highlight', 'category_id', 'id')->where('status', 1)->orderBy('category_highlights.position');
    // }
}
