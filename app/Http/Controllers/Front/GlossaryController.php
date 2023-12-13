<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\ProductCategory1;
use App\Models\SeoPage;

class GlossaryController extends Controller
{
    public function index(Request $request)
    {
        
        $seo = SeoPage::where('page', 'glossary')->first();
        $categories = ProductCategory1::where('parent_id', 0)->where('status', 1)->orderBy('position')->get();
        return view('front.glossary.index', compact('categories', 'seo'));
    }
}
