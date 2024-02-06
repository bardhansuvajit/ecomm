<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\ProductPriceRangeFilter;
use App\Models\ProductCategory1;
use App\Models\SeoPage;

class ShopController extends Controller
{
    public function index(Request $request)
    {
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

        $products = Product::select('products.*')
        ->leftJoin('product_pricings', 'products.id', '=', 'product_pricings.product_id')
        ->where('products.status', 1)
        ->orderBy($orderBy, $sortBy)
        ->groupBy('products.id')
        ->paginate(applicationSettings()->pagination_items_per_page);

        $seo = SeoPage::where('page', 'shop')->first();
        return view('front.shop.index', compact('seo', 'products', 'request'));





        /*
        $seo = SeoPage::where('page', 'shop')->first();
        $priceRanges = ProductPriceRangeFilter::where('status', 1)->orderBy('min_value')->get();
        $maxRangePrice = ProductPriceRangeFilter::select('max_value')->latest('id')->first();

        // DB::enableQueryLog();
        // dd($request->subcategory);

        $query = Product::query();

        // category
        if (!empty($request->category) && count($request->category) > 0) {
            foreach($request->category as $singleCategoryId) {
                $query->orWhere('category_id', $singleCategoryId);
            }
        }

        // price
        if (!empty($request->price) && count($request->price) > 0) {
            foreach($request->price as $singlePrice) {
                foreach($priceRanges as $rangeIndex => $range) {
                    if ($singlePrice == $range->set_name) {
                        $query->orWherebetween('selling_price', [$range->min_value, $range->max_value]);
                    }

                    if ( $singlePrice == (count($priceRanges) + 1) ) {
                        $query->orWhere('selling_price', '>', $maxRangePrice->max_value);
                    }
                }
            }
        }

        // subcategory
        if (!empty($request->subcategory) && count($request->subcategory) > 0) {
            // dd('here');
            foreach($request->subcategory as $singleSubCategoryId) {
                // dd($singleSubCategoryId);
                $query->orWhere('subcategory_id', $singleSubCategoryId);
            }
        }

        $data = $query->where('status', '!=', 2)->latest('id')->paginate(9);

        // dd(DB::getQueryLog());

        // $data = Product::where('status', 1)->latest('id')->paginate(9);
        return view('front.shop.index', compact('data', 'seo', 'request', 'priceRanges'));
        */
    }

}
