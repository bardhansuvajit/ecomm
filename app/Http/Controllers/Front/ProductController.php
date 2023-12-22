<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductWatchlist;

// use App\Models\Cart;
// use App\Models\ProductCategory;
// use App\Models\ProductWishlist;

class ProductController extends Controller
{
    public function detail(Request $request, $slug)
    {
        $data = Product::where('slug', $slug)->where('status', 1)->first();

        if (!empty($data)) {
            $categories = DB::select("SELECT pc.level, 
            c1.title AS c1_title, c1.slug AS c1_slug, 
            c2.title AS c2_title, c2.slug AS c2_slug, 
            c3.title AS c3_title, c3.slug AS c3_slug, 
            c4.title AS c4_title, c4.slug AS c4_slug 
            FROM `product_categories` AS pc
            LEFT JOIN product_category1s AS c1
            ON pc.category_id = c1.id AND pc.level = 1
            LEFT JOIN product_category2s AS c2
            ON pc.category_id = c2.id AND pc.level = 2
            LEFT JOIN product_category3s AS c3
            ON pc.category_id = c3.id AND pc.level = 3
            LEFT JOIN product_category4s AS c4
            ON pc.category_id = c4.id AND pc.level = 4
            ORDER BY pc.level");

            // add to watchlist
            $watchlist = new ProductWatchlist();
            $watchlist->product_id = $data->id;
            $watchlist->user_id = (auth()->guard('web')->check()) ? auth()->guard('web')->user()->id : '';
            $watchlist->ip_address = ipfetch();
            $watchlist->save();

            return view('front.product.detail', compact('data', 'categories'));
        } else {
            return redirect()->route('front.error.404');
        }

        /*
        $cartRedirectTo = $wishlistToggle = '';
        $data = Product::where('slug', $slug)->where('status', 1)->first();

        // if product exists
        if (!empty($data)) {
            Product::where('slug', $slug)->update([
                'view_count' => $data->view_count + 1
            ]);

            $allCategories = $data->categoryDetails;
            $related_products = [];

            foreach ($allCategories as $index => $category) {
                $related_products[] = ProductProductCategory1::where('category_id', $category->category_id)->where('product_id', '!=', $data->id)->get();
            }

            // if user is logged in
            if (auth()->guard('web')->check()) {
                $productExistsInCart = Cart::where('user_id', auth()->guard()->user()->id)->where('product_id', $data->id)->first();

                if (!empty($productExistsInCart)) {
                    $cartRedirectTo = 'cart';
                }

                $wishlistCheck = ProductWishlist::where('user_id', auth()->guard()->user()->id)->where('product_id', $data->id)->first();

                if (!empty($wishlistCheck)) {
                    $wishlistToggle = 'active';
                }
            }
            // if user not logged in
            else {
                if (!empty($_COOKIE['_cart-token'])) {
                    $token = $_COOKIE['_cart-token'];
                    $productExistsInCart = Cart::where('guest_token', $token)->where('product_id', $data->id)->first();

                    if (!empty($productExistsInCart)) {
                        $cartRedirectTo = 'cart';
                    }
                }
            }

            return view('front.product.detail', compact('data', 'related_products', 'cartRedirectTo', 'wishlistToggle'));
        } else {
            return redirect()->route('front.error.404');
        }
        */
    }

    // public function wishlistToggle(Request $request, $id)
    // {
    //     // check if user is logged in
    //     if (!auth()->guard('web')->check()) {
    //         return response()->json([
    //             'status' => 400,
    //             'message' => 'You have to login to wishlist product'
    //         ]);
    //     }

    //     // check if product is already wishlisted
    //     $wishlistCheck = ProductWishlist::where('user_id', auth()->guard('web')->user()->id)->where('product_id', $id)->first();

    //     if (!empty($wishlistCheck)) {
    //         ProductWishlist::where('id', $wishlistCheck->id)->delete();

    //         return response()->json([
    //             'status' => 200,
    //             'message' => 'Product removed from wishlist',
    //         ]);
    //     }

    //     $data = new ProductWishlist();
    //     $data->user_id = auth()->guard('web')->user()->id;
    //     $data->product_id = $id;
    //     $data->save();

    //     return response()->json([
    //         'status' => 200,
    //         'message' => 'Product added to wishlist',
    //     ]);

    // }
}
