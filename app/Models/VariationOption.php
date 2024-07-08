<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VariationOption extends Model
{
    use HasFactory, SoftDeletes;

    public function parent() {
        return $this->belongsTo('App\Models\Variation', 'variation_id', 'id');
    }
}
