<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariation extends Model
{
    use HasFactory, SoftDeletes;

    public function product() {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }

    public function variationOption() {
        return $this->belongsTo('App\Models\VariationOption', 'variation_option_id', 'id');
    }

    public function pricing() {
        return $this->hasMany('App\Models\ProductPricing', 'product_variation_id', 'id');
    }

    public function images() {
        return $this->hasMany('App\Models\ProductImage', 'product_variation_id', 'id')->orderBy('position');
    }

}
