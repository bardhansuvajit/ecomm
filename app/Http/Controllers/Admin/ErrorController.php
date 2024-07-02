<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ErrorController extends Controller
{
    // Unauthorized
    public function err401(Request $request)
    {
        return view('admin.error.401');
    }

    // Forbidden
    public function err403(Request $request)
    {
        return view('admin.error.403');
    }

    // Not Found
    public function err404(Request $request)
    {
        return view('admin.error.404');
    }

}
