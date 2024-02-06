<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariationChild extends Model
{
    use HasFactory, SoftDeletes;

    public function parentDetail()
    {
        return $this->belongsTo('App\Models\ProductVariationParent', 'parent_id', 'id');
    }
}
