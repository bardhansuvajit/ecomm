<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function productDetails()
    {
        return $this->hasMany('App\Models\OrderProduct', 'order_id', 'id');
    }

    public function userDetails()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function addressDetails()
    {
        return $this->hasOne('App\Models\OrderAddress', 'id', 'order_address_id');
    }
}
