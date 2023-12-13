<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\SeoPage;
use App\Models\Collection;
use App\Models\ProductFeature;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $data = (object)[];
        $data->seo = SeoPage::where('page', 'home')->first();
        $data->banners = Banner::where('status', 1)->orderBy('position')->get();
        $data->collections = Collection::where('status', 1)->orderBy('position')->get();
        $data->featuredProducts = ProductFeature::orderBy('position')->get();

        return view('front.index', compact('data'));
    }
}
