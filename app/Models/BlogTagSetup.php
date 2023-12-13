<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogTagSetup extends Model
{
    use HasFactory;

    public function tagDetail()
    {
        return $this->belongsTo('App\Models\BlogTag', 'tag_id', 'id');
    }
}
