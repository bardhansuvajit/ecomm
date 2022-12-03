<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Cart;
use App\Models\Address;

class CartController extends Controller
{
    public function __construct()
    {
        $this->ip = $_SERVER['REMOTE_ADDR'];
    }

    public function index(Request $request)
    {
        $data = (object) [];

        
        if (auth()->guard('web')->check()) {
            $data->cart = Cart::where('user_id', auth()->guard('web')->user()->id)->latest('id')->where('save_for_later', 0)->get();
            
            $data->address = Address::where('user_id', auth()->guard('web')->user()->id)->where('selected', 1)->first();
        } else {
            $data->cart = $data->address = [];

            if (!empty($_COOKIE['_cart-token'])) {
                $token = $_COOKIE['_cart-token'];
                $data->cart = Cart::where('guest_token', $token)->latest('id')->where('save_for_later', 0)->get();
            }
            // $data->cart = Cart::where('ip', $this->ip)->latest('id')->where('save_for_later', 0)->get();
            // $data->address = Address::where('ip_address', $this->ip)->where('selected', 1)->first();
        }

        return view('front.cart.index', compact('data'));
    }

    public function add(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'product_id' => 'required|integer|min:1'
        ]);

        // check if product exists in cart
        if (auth()->guard('web')->check()) {
            $productExistsInCart = Cart::where('user_id', auth()->guard('web')->user()->id)->where('product_id', $request->product_id)->first();
        } else {
            $productExistsInCart = Cart::where('ip', $this->ip)->where('product_id', $request->product_id)->first();
        }

        // if product exists in cart
        if (!empty($productExistsInCart)) {
            $productExistsInCart->qty = $productExistsInCart->qty + 1;
            $productExistsInCart->save();
        } else {
            $cart = new Cart();
            $cart->user_id = auth()->user() ? auth()->user()->id : 0;
            $cart->product_id = $request->product_id;
            $cart->coupon_code = 0;
            $cart->ip = $this->ip;
            $cart->save();
        }

        // return redirect()->back()->with('success', 'Product added to cart');
        return redirect()->route('front.cart.index')->with('success', 'Product added to cart');
    }

    public function remove(Request $request, $id)
    {
        $product = Cart::where('id', $id)->delete();
        return redirect()->route('front.cart.index')->with('success', 'Product removed from cart');
    }

    public function save(Request $request, $id)
    {
        $cart = Cart::findOrFail($id);

        if ($cart->save_for_later == 0) {
            $updatedSaved = 1;
            $message = "Product saved for later";
        } else {
            $updatedSaved = 0;
            $message = "Product moved to cart";
        }

        $cart->save_for_later = $updatedSaved;
        $cart->save();
        return redirect()->route('front.cart.index')->with('success', $message);
    }

    public function quantity(Request $request)
    {
        $request->validate([
            "qty" => "required|integer|min:1",
            "id" => "required|integer|min:1",
        ]);
        $cart = Cart::findOrFail($request->id);
        $cart->qty = $request->qty;
        $cart->save();
        return redirect()->route('front.cart.index')->with('success', 'Product quantity updated');
    }
}
