<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Blog;
use App\Models\SeoPage;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $seo = SeoPage::where('page', 'blog')->first();
        $data = Blog::where('status', 1)->latest('id')->paginate(9);
        return view('front.blog.index', compact('data', 'seo'));
    }

    public function detail(Request $request, $slug)
    {
        $data = Blog::where('slug', $slug)->where('status', 1)->first();

        if (!empty($data)) {
            return view('front.blog.detail', compact('data'));
        } else {
            return redirect()->route('front.error.404');
        }
    }

}
