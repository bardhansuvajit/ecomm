<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    public function countryDetails()
    {
        return $this->belongsTo('App\Models\Country', 'country', 'name');
    }

    public function stateDetails()
    {
        return $this->belongsTo('App\Models\State', 'state', 'name');
    }
}
