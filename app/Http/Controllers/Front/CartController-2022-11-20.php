<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Cart;
use App\Models\Address;
use App\Models\Product;

class CartController extends Controller
{
    public function __construct()
    {
        $this->ip = $_SERVER['REMOTE_ADDR'];
    }

    public function index(Request $request)
    {
        $data = (object) [];
        $data->cart = [];

        if (auth()->guard('web')->check()) {
            $cartProduct = Cart::where('user_id', auth()->guard('web')->user()->id)
            ->where('save_for_later', 0)
            ->with('couponDetails')
            ->latest('id')
            ->get();

            // dd($cartProduct);

            foreach($cartProduct as $cart) {
                $productDetail = Product::findOrFail($cart->product_id);

                $data->cart[] = [
                    'id' => $productDetail->id,
                    'title' => $productDetail->title,
                    'slug' => $productDetail->slug,
                    'price' => $productDetail->price,
                    'offer_price' => $productDetail->offer_price,
                    'image' => $productDetail->imageDetails[0]->img_50,
                    'qty' => $cart->qty,
                    'cart_id' => $cart->id,
                    'coupon_code' => $cart->coupon_code,
                    'coupon_type' => $cart->couponDetails ? $cart->couponDetails->type : '',
                    'coupon_discount' => $cart->couponDetails ? $cart->couponDetails->amount : '',
                    'coupon_code_name' => $cart->couponDetails ? $cart->couponDetails->coupon_code : '',
                ];
            }

            // dd($data->cart);

            $data->address = Address::where('user_id', auth()->guard('web')->user()->id)->where('selected', 1)->first();
        } else {
            if (!empty($_COOKIE['cartProducts'])) {
                $cartProduct = json_decode($_COOKIE['cartProducts']);

                if (count($cartProduct) > 0) {
                    foreach($cartProduct as $product) {
                        $productDetail = Product::findOrFail($product->id);

                        $data->cart[] = [
                            'id' => $productDetail->id,
                            'title' => $productDetail->title,
                            'slug' => $productDetail->slug,
                            'price' => $productDetail->price,
                            'offer_price' => $productDetail->offer_price,
                            'image' => $productDetail->imageDetails[0]->img_50,
                            'qty' => $product->qty,
                        ];
                    }
                }
            }
        }

        return view('front.cart.index', compact('data'));
    }

    public function add(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'user_id' => 'required|integer|min:1',
            'product_id' => 'required|integer|min:1'
        ]);

        $productExistsInCart = Cart::where('user_id', auth()->guard('web')->user()->id)->where('product_id', $request->product_id)->first();

        // if product exists in cart
        if (!empty($productExistsInCart)) {
            $productExistsInCart->qty = $productExistsInCart->qty + 1;
            $productExistsInCart->save();
        } else {
            $cart = new Cart();
            $cart->user_id = auth()->guard('web')->user()->id;
            $cart->product_id = $request->product_id;
            $cart->coupon_code = 0;
            $cart->ip = $this->ip;
            $cart->save();
        }

        return redirect()->route('front.cart.index')->with('success', 'Product added to cart');

        // return response()->json([
        //     'status' => 200,
        //     'message' => 'Product added to cart'
        // ]);
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
