<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ErrorController extends Controller
{
    // Not Found
    public function err404(Request $request)
    {
        return view('front.error.404');
    }

    // Unauthorized
    public function err401(Request $request)
    {
        return view('front.error.401');
    }

}
