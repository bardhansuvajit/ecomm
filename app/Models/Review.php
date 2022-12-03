<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    public function userDetail()
    {
        return $this->belongsTo('\App\Models\User', 'user_id', 'id');
    }

    public function fileDetail()
    {
        return $this->hasMany('\App\Models\ReviewFile', 'review_id', 'id')->limit(5);
    }

    public function likeDetail()
    {
        return $this->hasMany('\App\Models\ReviewInteract', 'review_id', 'id')->where('type', 1);
    }

    public function dislikeDetail()
    {
        return $this->hasMany('\App\Models\ReviewInteract', 'review_id', 'id')->where('type', 0);
    }

    // logged in user like check
    public function likeDetailUserCheck()
    {
        if ( auth()->guard('web')->check()) {
            return $this->hasMany('\App\Models\ReviewInteract', 'review_id', 'id')->where('type', 1)->where('user_id', auth()->guard('web')->user()->id);
        } else {
            return false;
        }
    }

    // logged in user dislike check
    public function dislikeDetailUserCheck()
    {
        if ( auth()->guard('web')->check()) {
            return $this->hasMany('\App\Models\ReviewInteract', 'review_id', 'id')->where('type', 0)->where('user_id', auth()->guard('web')->user()->id);
        } else {
            return false;
        }
    }
}
