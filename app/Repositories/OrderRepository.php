<?php

namespace App\Repositories;
use Illuminate\Support\Facades\DB;
use App\Interfaces\OrderInterface;
use App\Interfaces\CartInterface;
use App\Interfaces\CouponInterface;
use App\Interfaces\UserInterface;
use App\Interfaces\UserAddressInterface;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\OrderAddress;
use App\Models\CouponUsage;

class OrderRepository implements OrderInterface
{
    private CartInterface $cartRepository;
    private CouponInterface $couponRepository;
    private UserInterface $userRepository;
    private UserAddressInterface $userAddressRepository;

    public function __construct(CartInterface $cartRepository, CouponInterface $couponRepository, UserInterface $userRepository, UserAddressInterface $userAddressRepository)
    {
        $this->cartRepository = $cartRepository;
        $this->couponRepository = $couponRepository;
        $this->userRepository = $userRepository;
        $this->userAddressRepository = $userAddressRepository;
    }

    public function create(array $data)
    {
        // dd($data);

        $response = [];

        DB::beginTransaction();

        try {
            // cart details
            $resp = $this->cartRepository->fetch();

            // if cart data
            if ($resp['status'] == "success") {
                // coupon validation check
                if ($resp['data'][0]->coupon_code != 0) {
                    $couponResp = $this->couponRepository->check($resp['data'][0]->couponDetails->code);

                    // if coupon check failure
                    if ($couponResp['status'] == "failure") {
                        // remove coupon
                        $this->couponRepository->remove($resp['data']);
                    }
                }
            } else {
                $response = [
                    'status' => 'failure',
                    'message' => 'Something happened',
                ];
                return $response;
            }

            $userData = $this->userRepository->findById($data['user_id']);

            if ($userData['status'] == "failure") {
                $response = [
                    'status' => 'failure',
                    'message' => 'User not found. Try again',
                ];
                return $response;
            }

            // cart details
            $guestToken = cartDetails($resp['data'])['guestToken'];
            $totalCartAmount = cartDetails($resp['data'])['totalCartAmount'];
            $currencyId = cartDetails($resp['data'])['currencyId'];
            // $currencyIcon = cartDetails($resp['data'])['currencyIcon'];
            $taxApplicable = cartDetails($resp['data'])['taxApplicable'];
            $taxPercentage = cartDetails($resp['data'])['taxPercentage'];
            $taxCharge = cartDetails($resp['data'])['taxCharge'];
            $shippingChargeMinCartValue = cartDetails($resp['data'])['shippingChargeMinCartValue'];
            $shippingCharge = cartDetails($resp['data'])['shippingCharge'];
            $finalCartValue = cartDetails($resp['data'])['finalCartValue'];

            $couponId = cartDetails($resp['data'])['couponId'];
            $couponApplicable = cartDetails($resp['data'])['couponApplicable'];
            $couponDiscount = cartDetails($resp['data'])['couponDiscount'];
            $couponType = cartDetails($resp['data'])['couponType'];
            $couponDiscountAmountDB = cartDetails($resp['data'])['couponDiscountAmountDB'];

            // dd(cartDetails($resp['data']));

            // order table
            $newOrder = new Order();
            $newOrder->order_no = orderNumberGenerate();
            $newOrder->user_id = $userData['data']->id;
            $newOrder->guest_token = $guestToken;
            $newOrder->user_full_name = $userData['data']->first_name.' '.$userData['data']->last_name;
            $newOrder->user_email = $userData['data']->email;
            $newOrder->user_phone_no = $userData['data']->mobile_no;
            $newOrder->user_phone_no_alt = $userData['data']->alt_no ?? '';
            $newOrder->user_whatsapp_no = $userData['data']->whatsapp_no ?? '';
            $newOrder->delivery_method = 'default';
            $newOrder->payment_method = $data['payment_method'] ?? '';
            $newOrder->total_cart_amount = $totalCartAmount;
            $newOrder->tax_in_percentage = $taxPercentage;
            $newOrder->tax_in_amount = $taxCharge;
            $newOrder->shipping_charge = $shippingCharge;
            $newOrder->payment_method_charge = 0;
            $newOrder->coupon_discount = $couponDiscount;
            $newOrder->final_order_amount = $finalCartValue;
            $newOrder->txn_id = '';
            $newOrder->ip_address = ipfetch();
            $newOrder->latitude = '';
            $newOrder->longitude = '';
            $newOrder->save();

            // products
            foreach($resp['data'] as $cartProduct) {
                $orderProduct = new OrderProduct();
                $orderProduct->order_id = $newOrder->id;
                $orderProduct->product_id = $cartProduct->product_id;
                $orderProduct->product_title = $cartProduct->productDetails->title;
                if ($cartProduct->productDetails->frontImageDetails) {
                    if (count($cartProduct->productDetails->frontImageDetails) > 0) {
                        $orderProduct->product_image = $cartProduct->productDetails->frontImageDetails[0]->img_medium;
                    } else {
                        $orderProduct->product_image = 'uploads/static-front-missing-image/product.svg';
                    }
                }
                $orderProduct->product_slug = $cartProduct->productDetails->slug;
                $orderProduct->currency_id = $currencyId;
                $orderProduct->currency_entity = currencyDetails($currencyId)->entity;
                $orderProduct->currency_short_name = currencyDetails($currencyId)->short_name;
                if ($cartProduct->productDetails->pricing) {
                    $orderProduct->mrp = productPricing($cartProduct->productDetails)['mrp'];
                    $orderProduct->selling_price = productPricing($cartProduct->productDetails)['selling_price'];
                }
                $orderProduct->variation_id = 0;
                $orderProduct->variation_payload = '';
                $orderProduct->qty = $cartProduct->qty;
                $orderProduct->status = 'new';
                $orderProduct->cancel_reason = '';
                $orderProduct->return_reason = '';
                $orderProduct->save();
            }

            // address
            // get delivery/shipping address
            $deliveryAddressData = $this->userAddressRepository->orderAddress($userData['data']->id, 'delivery');

            if ($deliveryAddressData['status'] == "failure") {
                $response = [
                    'status' => 'failure',
                    'message' => 'Something happened',
                ];
                return $response;
            }

            if ($data['billing_same_as_shipping'] == 'false') {
                $billingAddressData = $this->userAddressRepository->orderAddress($userData['data']->id, 'billing');
            } else {
                $billingAddressData = $deliveryAddressData;
            }

            // dd($deliveryAddressData['data']);

            $address = new OrderAddress();
            $address->order_id = $newOrder->id;
            $address->shipping_address_user_full_name = $deliveryAddressData['data']->full_name;
            $address->shipping_address_user_phone_no1 = $deliveryAddressData['data']->contact_no1;
            $address->shipping_address_user_phone_no2 = $deliveryAddressData['data']->contact_no2;
            $address->shipping_address_postcode = $deliveryAddressData['data']->zipcode;
            $address->shipping_address_country = $deliveryAddressData['data']->country;
            $address->shipping_address_state = $deliveryAddressData['data']->state;
            $address->shipping_address_city = $deliveryAddressData['data']->city;
            $address->shipping_address_street_address = $deliveryAddressData['data']->street_address;
            $address->shipping_address_locality = $deliveryAddressData['data']->locality;
            $address->shipping_address_landmark = $deliveryAddressData['data']->landmark;
            $address->shipping_address_type = $deliveryAddressData['data']->type;
            $address->shipping_address_latitude = '';
            $address->shipping_address_longitude = '';

            $address->billing_address_user_full_name = $billingAddressData['data']->full_name;
            $address->billing_address_user_phone_no1 = $billingAddressData['data']->contact_no1;
            $address->billing_address_user_phone_no2 = $billingAddressData['data']->contact_no2;
            $address->billing_address_postcode = $billingAddressData['data']->zipcode;
            $address->billing_address_country = $billingAddressData['data']->country;
            $address->billing_address_state = $billingAddressData['data']->state;
            $address->billing_address_city = $billingAddressData['data']->city;
            $address->billing_address_street_address = $billingAddressData['data']->street_address;
            $address->billing_address_locality = $billingAddressData['data']->locality;
            $address->billing_address_landmark = $billingAddressData['data']->landmark;
            $address->billing_address_type = $billingAddressData['data']->type;
            $address->billing_address_latitude = '';
            $address->billing_address_longitude = '';
            $address->save();

            // coupon
            if ($couponId != 0) {
                // dd($resp['data'][0]->couponDetails->couponDiscount);

                $currencyData = ipToCurrency();
                $currencyId = $currencyData->currency_id;
                $couponDiscountData = $resp['data'][0]->couponDetails->couponDiscount;

                foreach($couponDiscountData as $discountdata) {
                    if ($discountdata->currency_id == $currencyId) {
                        $discount_type = $discountdata->discount_type;
                        $discount_amount = $discountdata->discount_amount;
                    }
                }

                $usage = new CouponUsage();
                $usage->coupon_id = $couponId;
                $usage->order_id = $newOrder->id;
                $usage->coupon_name = $resp['data'][0]->couponDetails->name;
                $usage->coupon_code = $resp['data'][0]->couponDetails->code;
                $usage->discount_type = $discount_type;
                $usage->discount_amount = $discount_amount;
                $usage->save();
            }

            // empty cart
            foreach($resp['data'] as $cartProduct) {
                $this->cartRepository->remove($cartProduct->id);
                // Cart::where('id', $cartProduct->id)->delete();
            }

            DB::commit();

            $response = [
                'status' => 'success',
                'message' => 'Order placed successfully',
                'data' => $newOrder,
            ];
            return $response;

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;

            $response = [
                'status' => 'failure',
                'message' => 'Something happened',
            ];
            return $response;
        }
    }

    public function findById(int $id)
    {
        $data = Order::findOrFail($id);

        if (!empty($data)) {
            $response = [
                'status' => 'success',
                'message' => 'Order data fetch',
                'data' => $data,
            ];
        } else {
            $response = [
                'status' => 'failure',
                'message' => 'Order data not found',
            ];
        }

        return $response;
    }

    public function findByorderNo(string $order_no, int $userId)
    {
        $response = [];

        $data = Order::where('user_id', $userId)->where('order_no', $order_no)->first();

        if (!empty($data)) {
            $response = [
                'status' => 'success',
                'message' => 'Order data fetch',
                'type' => 'logged-in user',
                'data' => $data,
            ];
        } else {
            $response = [
                'status' => 'failure',
                'message' => 'Order data not found',
            ];
        }

        return $response;

        /*
        if (auth()->guard('web')->check()) {
            $userId = auth()->guard('web')->user()->id;
            $data = Order::where('user_id', $userId)->where('order_no', $order_no)->first();

            if (!empty($data)) {
                $response = [
                    'status' => 'success',
                    'message' => 'Order data fetch',
                    'type' => 'logged-in user',
                    'data' => $data,
                ];
            } else {
                $response = [
                    'status' => 'failure',
                    'message' => 'Order data not found',
                ];
            }

            return $response;
        } else {
            if (!empty($_COOKIE['_cart-token'])) {
                $token = $_COOKIE['_cart-token'];
                $data = Order::where('guest_token', $token)->where('order_no', $order_no)->first();

                if (!empty($data)) {
                    $response = [
                        'status' => 'success',
                        'message' => 'Order data fetch',
                        'type' => 'guest user',
                        'data' => $data,
                    ];
                } else {
                    $response = [
                        'status' => 'failure',
                        'message' => 'Order data not found',
                    ];
                }

                return $response;
            }

            $response = [
                'status' => 'failure',
                'message' => 'Something happened',
            ];
            return $response;

        }
        */
        // return Order::where('order_no', $order_no)->first();
    }

    public function listAll(string $keyword)
    {
        $query = Order::query();

        $query->when($keyword, function($query) use ($keyword) {
            $query->where('order_no', 'like', '%'.$keyword.'%')
            ->orWhere('user_full_name', 'like', '%'.$keyword.'%')
            ->orWhere('user_email', 'like', '%'.$keyword.'%')
            ->orWhere('user_phone_no', 'like', '%'.$keyword.'%')
            ->orWhere('user_phone_no_alt', 'like', '%'.$keyword.'%')
            ->orWhere('user_whatsapp_no', 'like', '%'.$keyword.'%')
            ->orWhere('final_order_amount', 'like', '%'.$keyword.'%');
        });

        $data = $query->latest('id')->paginate(25);

        $response = [
            'status' => 'success',
            'message' => 'Order detail found',
            'data' => $data
        ];
        return $response;
    }

    public function findByUserId(int $userId) : array
    {
        $data = Order::where('user_id', $userId)->latest('id')->paginate(10);

        if (count($data) > 0) {
            $response = [
                'status' => 'success',
                'message' => 'Data found',
                'data' => $data
            ];
            return $response;
        } else {
            $response = [
                'status' => 'failure',
                'message' => 'Data not found'
            ];
            return $response;
        }
    }
}
