<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogFeature extends Model
{
    use HasFactory;

    public function blogDetail()
    {
        return $this->belongsTo('App\Models\Blog', 'blog_id', 'id');
    }
}
