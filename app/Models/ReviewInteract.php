<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewInteract extends Model
{
    use HasFactory;

    public function userDetail()
    {
        return $this->belongsTo('\App\Models\User', 'user_id', 'id');
    }

    public function reviewDetail()
    {
        return $this->belongsTo('\App\Models\User', 'review_id', 'id');
    }
}
