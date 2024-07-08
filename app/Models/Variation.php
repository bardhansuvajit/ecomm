<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Variation extends Model
{
    use HasFactory, SoftDeletes;

    public function options() {
        return $this->hasMany('App\Models\VariationOption', 'variation_id', 'id');
    }

    public function activeOptions() {
        return $this->hasMany('App\Models\VariationOption', 'variation_id', 'id')->where('status', 1)->orderBy('category')->orderBy('position');
    }

    public function activeOptionsLimited() {
        return $this->hasMany('App\Models\VariationOption', 'variation_id', 'id')->limit(3);
    }
}
