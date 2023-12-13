<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;

    function productsDetails()
    {
        return $this->hasMany('App\Models\ProductCollection', 'collection_id', 'id');
    }
}
