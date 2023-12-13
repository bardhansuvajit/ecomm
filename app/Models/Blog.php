<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    public function tagDetails()
    {
        return $this->hasMany('App\Models\BlogTagSetup', 'blog_id', 'id');
    }

    // public function category2Details()
    // {
    //     return $this->hasMany('App\Models\BlogCategorySetup', 'blog_id', 'id')->where('level', 2);
    // }
}
