<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Service;

class ServiceController extends Controller
{
    // public function index(Request $request)
    // {
    //     $data = Service::where('status', 1)->latest('id')->get();
    //     return view('front.service.index', compact('data'));
    // }

    public function detail(Request $request, $slug)
    {
        $data = Service::where('slug', $slug)->where('status', 1)->first();

        if (!empty($data)) {
            return view('front.service.detail', compact('data'));
        } else {
            return redirect()->route('front.error.404');
        }
    }

}
