<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategory2 extends Model
{
    use HasFactory;

    public function category1Details()
    {
        return $this->belongsTo('App\Models\BlogCategory1', 'cat1_id', 'id');
    }
}
