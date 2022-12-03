<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Wishlist;

class ProductController extends Controller
{
    public function detail(Request $request, $slug)
    {
        $data = Product::where('slug', $slug)->first();
        $cartRedirectTo = $wishlistToggle = '';

        if ($data) {
            // check if product is added to cart for guest user
            if (auth()->guard('web')->check()) {
                $productExistsInCart = Cart::where('user_id', auth()->guard()->user()->id)->where('product_id', $data->id)->first();

                if (!empty($productExistsInCart)) {
                    $cartRedirectTo = 'cart';
                }

                $wishlistCheck = Wishlist::where('user_id', auth()->guard()->user()->id)->where('product_id', $data->id)->first();

                if (!empty($wishlistCheck)) {
                    $wishlistToggle = 'active';
                }
            } else {
                if (!empty($_COOKIE['_cart-token'])) {
                    $token = $_COOKIE['_cart-token'];
                    $productExistsInCart = Cart::where('guest_token', $token)->where('product_id', $data->id)->first();

                    if (!empty($productExistsInCart)) {
                        $cartRedirectTo = 'cart';
                    }
                }
            }

            return view('front.product.detail', compact('data', 'cartRedirectTo', 'wishlistToggle'));
        } else {
            return view('front.error.404');
        }
    }

}
