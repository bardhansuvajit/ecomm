<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponMinimumCartAmount extends Model
{
    use HasFactory;

    public function currencyDetails()
    {
        return $this->belongsTo('App\Models\Currency', 'currency_id', 'id');
    }
}
