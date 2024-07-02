<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminPermissionCategory extends Model
{
    use HasFactory;

    public function subCategories() {
        return $this->hasMany('App\Models\AdminPermissionSubCategory', 'category_id', 'id');
    }
}
