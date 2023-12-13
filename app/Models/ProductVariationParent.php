<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariationParent extends Model
{
    use HasFactory;

    public function variationChildern()
    {
        return $this->hasMany('App\Models\ProductVariationChild', 'parent_id', 'id')->orderBy('position');
    }

    public function frontVariationChildern()
    {
        return $this->hasMany('App\Models\ProductVariationChild', 'parent_id', 'id')->where('status', 1)->orderBy('position');
    }
}
