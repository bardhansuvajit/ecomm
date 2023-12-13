<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryHighlight extends Model
{
    use HasFactory;

    public function categoryDetails() {
        return $this->belongsTo('App\Models\ProductCategory1', 'category_id', 'id');
    }
}
