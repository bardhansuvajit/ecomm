<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategory1 extends Model
{
    use HasFactory;

    public function category2Details()
    {
        return $this->hasMany('App\Models\BlogCategory2', 'cat1_id', 'id');
    }
}
