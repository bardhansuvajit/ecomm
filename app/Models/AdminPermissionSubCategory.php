<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminPermissionSubCategory extends Model
{
    use HasFactory;

    public function permissionDetail() {
        return $this->hasOne('App\Models\AdminRolePermissionMapping', 'permission_sub_cat_id', 'id');
    }
}
