<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategorySetup extends Model
{
    use HasFactory;

    public function category1Detail()
    {
        return $this->belongsTo('App\Models\BlogCategory1', 'category_id', 'id');
    }

    public function category2Detail()
    {
        return $this->belongsTo('App\Models\BlogCategory2', 'category_id', 'id')->where('level', 2);
    }
}
