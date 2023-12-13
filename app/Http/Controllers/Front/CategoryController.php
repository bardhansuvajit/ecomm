<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\ProductCategory1;
use App\Models\Product;
use App\Models\ProductCategory;

class CategoryController extends Controller
{
    public function detail(Request $request)
    {
        return view('front.category.detail');

        $orderBy = "products.view_count";
        $sortBy = "desc";

        if($request->order == "date-desc") {
            $orderBy = "products.id";
            $sortBy = "desc";
        } elseif($request->order == "price-asc") {
            $orderBy = "product_pricings.selling_price";
            $sortBy = "asc";
        } elseif($request->order == "price-desc") {
            $orderBy = "product_pricings.selling_price";
            $sortBy = "desc";
        }

        $category = ProductCategory1::where('slug', $slug)->where('parent_id', 0)->where('status', 1)->first();

        $products = Product::select('products.*')->join('product_categories', 'products.id', '=', 'product_categories.product_id')
        ->leftJoin('product_pricings', 'products.id', '=', 'product_pricings.product_id')
        ->where('product_categories.category_id', $category->id)
        ->where('products.status', 1)
        ->orderBy($orderBy, $sortBy)
        ->groupBy('products.id')
        ->paginate(12);

        // dd($products);


        // $products = ProductProductCategory1::where('category_id', $category->id)->paginate(12);
        // $products = Product::where('category_id', $category->id)->where('status', 1)->orderBy($orderBy, $sortBy)->get();

        if (!empty($category)) {
            return view('front.category.index', compact('category', 'products', 'request'));
        } else {
            return redirect()->route('front.error.404');
        }
    }

    public function level2detail(Request $request, $level1slug, $level2slug)
    {
        $data = ProductCategory1::where('slug', $level2slug)->where('status', 1)->first();

        if (!empty($data)) {
            // check if this category is level 2
            if ($data->categoryDetails) {
                if ($data->categoryDetails->parent_id == 0) {
                    return view('front.category.level2', compact('data'));
                }
            }
        }

        return redirect()->route('front.error.404');
    }

    public function level3detail(Request $request, $level1slug, $level2slug, $level3slug)
    {
        $data = ProductCategory1::where('slug', $level3slug)->where('status', 1)->first();

        // dd($data);

        if (!empty($data)) {
            // check if this category is level 3
            if ($data->categoryDetails) {
                if ($data->categoryDetails->categoryDetails) {
                    if ($data->categoryDetails->categoryDetails->parent_id == 0) {
                        return view('front.category.level3', compact('data'));
                    }
                }
            }
        }

        return redirect()->route('front.error.404');
    }
}
