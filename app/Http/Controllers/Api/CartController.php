<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

use App\Interfaces\CouponInterface;
use App\Interfaces\CartInterface;

class CartController extends Controller
{
    private CouponInterface $couponRepository;
    private CartInterface $cartRepository;

    public function __construct(CouponInterface $couponRepository, CartInterface $cartRepository)
    {
        $this->couponRepository = $couponRepository;
        $this->cartRepository = $cartRepository;
        $this->ip = $_SERVER['REMOTE_ADDR'];
    }

    public function add(Request $request)
    {
        $maxQty = applicationSettings()->cart_max_product_qty;

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'product_id' => 'required|integer|min:1|exists:product_pricings,product_id',
            'qty' => 'required|integer|min:1|max:'.$maxQty,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                // 'message' => 'Something happened'
                'message' => $validator->errors()->first()
            ]);
        }

        // check if product can be purchsed/ product's status
        $product = Product::findOrFail($request->product_id);
        $productStatus = $product->statusDetail->purchase;

        if($productStatus != 1) {
            return response()->json([
                'status' => 400,
                'message' => 'This product can not be purchased'
            ]);
        }

        $token = '';

        // if user is logged in
        if ($request->user_id != 0) {
            // check if product exists in cart
            $productExistsInCart = Cart::where('user_id', $request->user_id)->where('product_id', $request->product_id)->first();

            if (!empty($productExistsInCart)) {
                $totalQty = $productExistsInCart->qty + $request->qty;

                if ($totalQty > $maxQty) {
                    $productExistsInCart->save_for_later = 0;
                    $productExistsInCart->save();
                    return response()->json([
                        'status' => 400,
                        // 'message' => 'You can add maximum '.$maxQty.' items',
                        'message' => 'You cannot add anymore item',
                        'quickCartShow' => true
                    ]);
                }

                $productExistsInCart->qty = $totalQty;
                $productExistsInCart->save_for_later = 0;
                $productExistsInCart->save();
            } else {
                $cart = new Cart();
                $cart->user_id = $request->user_id;
                $cart->product_id = $request->product_id;
                $cart->save_for_later = 0;
                $cart->qty = $request->qty;
                $cart->coupon_code = 0;
                $cart->ip = $this->ip;
                $cart->save();
            }

            // $cartCount = Cart::where('user_id', $request->user_id)->where('save_for_later', 0)->count();
            $cartCount = $this->cartRepository->countLoggedInUser($request->user_id);
        } else {
            // check if token exists
            if (!empty($_COOKIE['_cart-token'])) {
                $token = $_COOKIE['_cart-token'];

                // check if product exists in cart
                $productExistsInCart = Cart::where('guest_token', $token)->where('product_id', $request->product_id)->first();

                if (!empty($productExistsInCart)) {
                    $totalQty = $productExistsInCart->qty + $request->qty;

                    if ($totalQty > $maxQty) {
                        $productExistsInCart->save_for_later = 0;
                        $productExistsInCart->save();
                        return response()->json([
                            'status' => 400,
                            // 'message' => 'You can add maximum '.$maxQty.' items',
                            'message' => 'You cannot add anymore item',
                            'quickCartShow' => true
                        ]);
                    }

                    $productExistsInCart->qty = $totalQty;
                    $productExistsInCart->save();

                    // $cartCount = Cart::where('guest_token', $token)->where('save_for_later', 0)->count();
                    $cartCount = $this->cartRepository->countGuestUser();

                    return response()->json([
                        'status' => 200,
                        'token' => $token,
                        'count' => $cartCount['data'],
                        'message' => 'Product added to cart'
                    ]);
                }
            } else {
                $token = mt_rand_custom(10);
            }

            $cart = new Cart();
            $cart->user_id = 0;
            $cart->product_id = $request->product_id;
            $cart->save_for_later = 0;
            $cart->qty = $request->qty;
            $cart->ip = $this->ip;
            $cart->guest_token = $token;
            $cart->coupon_code = 0;
            $cart->save();

            // $cartCount = Cart::where('guest_token', $token)->where('save_for_later', 0)->count();
            $cartCount = $this->cartRepository->countGuestUser();
        }

        return response()->json([
            'status' => 200,
            'token' => $token,
            'count' => $cartCount['data'],
            'message' => 'Product added to cart'
        ]);
    }

    public function index(Request $request)
    {
        // cart data fetch
        $userId = $request->id;

        $resp = $this->cartRepository->fetchAjax($userId);

        // if data
        if ($resp['status'] == "success") {
            // coupon validation check
            if ($resp['data'][0]->coupon_code != 0) {
                $couponResp = $this->couponRepository->check($resp['data'][0]->couponDetails->code);

                // if failure
                if ($couponResp['status'] == "failure") {
                    // remove coupon
                    $this->couponRepository->remove($resp['data']);
                }
            }

            $cartProductsList = [];
            foreach ($resp['data'] as $key => $cartItem) {
                if (count($cartItem->productDetails->frontImageDetails) > 0) {
                    $imgPath = asset($cartItem->productDetails->frontImageDetails[0]->img_large);
                } else {
                    $imgPath = asset('frontend-assets/img/logo.png');
                }

                $cartProductsList[] = [
                    'image' => $imgPath,
                    'title' => $cartItem->productDetails->title,
                    'link' => route('front.product.detail', $cartItem->productDetails->slug),
                    'removeLink' => route('front.cart.remove', $cartItem->id),
                    'qty' => $cartItem->qty,
                    'currency' => productPricing($cartItem->productDetails)['currency'],
                    'selling_price' => productPricing($cartItem->productDetails)['selling_price'],
                ];
            }

            return response()->json([
                'status' => 200,
                'message' => $resp['message'],
                'data' => $cartProductsList,
                'amount' => cartDetails($resp['data']),
            ]);
        }

        return response()->json([
            'status' => 400,
            'message' => $resp['message']
        ]);

    }
}
