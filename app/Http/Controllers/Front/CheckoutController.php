<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Address;
use App\Models\UserPincode;
use App\Models\OrderAddress;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->ip = $_SERVER['REMOTE_ADDR'];
    }

    public function index(Request $request)
    {
        // dd($request->all());

        $data = (object) [];

        if (auth()->guard('web')->check()) {
            $data->cart = Cart::where('user_id', auth()->guard('web')->user()->id)->latest('id')->where('save_for_later', 0)->get();
            // $data->cart = Cart::where('ip', $this->ip)->orWhere('user_id', auth()->guard('web')->user()->id)->latest('id')->where('save_for_later', 0)->get();

            $data->address = Address::where('user_id', auth()->guard('web')->user()->id)->where('selected', 1)->first();
        } else {
            $data->cart = Cart::where('ip', $this->ip)->latest('id')->where('save_for_later', 0)->get();

            $data->address = Address::where('ip_address', $this->ip)->where('selected', 1)->first();
        }

        $data->user_pincode = UserPincode::where('ip_address', $this->ip)->where('selected', 1)->first();

        if (count($data->cart) > 0) {
            // if address is added goto checkout page or goto address
            if (!empty($data->address) && auth()->guard('web')->check()) {
                return view('front.checkout.index', compact('data'));
            } else {
                return redirect()->route('front.address.index');
            }
        } else {
            return redirect()->route('front.cart.index');
        }
    }

    public function order(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'payment_method' => 'required|string|min:2|max:255|in:cash-on-delivery,online-payment',
            'address_id' => 'required|integer',
            'delivery_method' => 'required||in:free,faster',
        ]);

        $user = auth()->guard('web')->user();

        DB::beginTransaction();

        try {
            // order address store
            $delivery_address = Address::findOrFail($request->address_id);

            $orderAddress = new OrderAddress();
            $orderAddress->user_id = $user->id;
            $orderAddress->full_name = $delivery_address->full_name;
            $orderAddress->mobile_no = $delivery_address->mobile_no;
            $orderAddress->whatsapp_no = $delivery_address->whatsapp_no;
            $orderAddress->alt_no = $delivery_address->alt_no;
            $orderAddress->email = $delivery_address->email;
            $orderAddress->pincode = $delivery_address->pincode;
            $orderAddress->locality = $delivery_address->locality;
            $orderAddress->city = $delivery_address->city;
            $orderAddress->state = $delivery_address->state;
            $orderAddress->country = $delivery_address->country;
            $orderAddress->street_address = $delivery_address->street_address;
            $orderAddress->landmark = $delivery_address->landmark;
            $orderAddress->type = $delivery_address->type;
            $orderAddress->ip_address = $this->ip;
            $orderAddress->latitude = $delivery_address->latitude;
            $orderAddress->longitude = $delivery_address->longitude;
            $orderAddress->status = 1;
            $orderAddress->save();

            // order table
            $newOrder = new Order();
            $newOrder->order_no = orderNumberGenerate();
            $newOrder->user_id = auth()->guard('web')->check() ? auth()->guard('web')->user()->id : 0;
            $newOrder->order_address_id = $orderAddress->id;

            $newOrder->delivery_method = $request->delivery_method;
            $newOrder->payment_method = ($request->payment_method == "cash-on-delivery") ? 'cod' : 'online';

            // cart data fetch
            $cartData = Cart::where('user_id', auth()->guard('web')->user()->id)
            ->where('save_for_later', 0)
            ->latest('id')
            ->get();

            $totalCartPrice = $totalQty = $singlePrice = $totalCartDiscount = $couponDiscount = $finalPayment = 0;
            foreach($cartData as $cartItem) {
                // total number of products in cart
                $totalQty += (int) $cartItem->qty;

                // calculate total cart discount
                $totalCartDiscount += (int) (($cartItem->productDetails->offer_price == 0.00) ? 0 : ($cartItem->productDetails->price - $cartItem->productDetails->offer_price)) * $cartItem->qty;

                // calculate total cart amount
                $totalCartPrice += (int) $cartItem->productDetails->price * $cartItem->qty;

                // final payment
                $finalPayment += (int) (($cartItem->productDetails->offer_price == 0) ? $cartItem->productDetails->price : $cartItem->productDetails->offer_price) * $cartItem->qty;
            }

            $newOrder->cart_total_order_amount = $totalCartPrice;
            $newOrder->cart_product_discount = $totalCartDiscount;

            // coupon details
            $newOrder->coupon_id = $cartData[0]->coupon_code;
            if ($cartData[0]->coupon_code != 0) {
                $coupon_discount = (int) $cartData[0]->couponDetails->amount;
                $coupon_type = (int) $cartData[0]->couponDetails->is_coupon;
            } else {
                $coupon_discount = 0;
                $coupon_type = 0;
            }
            $newOrder->coupon_discount = $coupon_discount;
            $newOrder->coupon_type = $coupon_type;

            // delivery charge
            $delivery_charge = (int) ($request->delivery_method == 'free') ? 0 : env('FASTER_DELIVERY_CHARGE');
            $newOrder->delivery_charges = $delivery_charge;

            // payment method charge
            $payment_method_charge = (int) ($request->payment_method == "cash-on-delivery") ? env('CASH_ON_DELIVERY_CHARGE') : 0;
            $newOrder->payment_method_charge = $payment_method_charge;

            // final payment = (cart-final - coupon-discount) + delivery-charge + payment-method-charge
            $newOrder->final_order_amount = (int) ($finalPayment - $coupon_discount) + $delivery_charge + $payment_method_charge;

            // ordered product
            $newOrder->total_order_product = count($cartData);
            $newOrder->total_order_qty = $totalQty;
            $newOrder->cancellation	= 0;
            $newOrder->cancellation_reason = '';

            $newOrder->save();

            // store in order product
            foreach($cartData as $cartItem) {
                $orderProduct = new OrderProduct();
                $orderProduct->order_id = $newOrder->id;
                $orderProduct->product_id = $cartItem->product_id;
                $orderProduct->product_title = $cartItem->productDetails->title;
                $orderProduct->product_image = $cartItem->productDetails->imageDetails[0]->img_50;
                $orderProduct->product_slug = $cartItem->productDetails->slug;
                $orderProduct->price = $cartItem->productDetails->price;
                $orderProduct->offer_price = $cartItem->productDetails->offer_price;
                $orderProduct->variation_id = 0;
                $orderProduct->qty = $cartItem->qty;
                $orderProduct->status = 1;
                $orderProduct->cancel_reason = '';
                $orderProduct->return_reason = '';
                $orderProduct->save();
            }

            // empty cart

            DB::commit();

            return redirect()->route('front.user.order.detail', $newOrder->id)->with('success', 'Thank you for placing order');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('failure', 'Something Happened');
        }
    }

    public function confirm(Request $request)
    {
        # code...
    }
}
