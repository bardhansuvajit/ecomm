<?php

namespace App\Repositories;

use App\Interfaces\CouponInterface;
use Illuminate\Support\Facades\DB;

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\CouponProduct;
use App\Models\CouponDiscount;
use App\Models\CouponMinimumCartAmount;

class CouponRepository implements CouponInterface
{
    public function check(string $code) : array
    {
        $response = [];
        // return Order::orderBy('id', 'desc')->paginate(25);
        $coupon = Coupon::where('code', $code)->first();
        $currentDateTime = date('Y-m-d H:i:s');

        // 1. check coupon status
        if ($coupon->status == 0) {
            $response = [
                'status' => 'failure',
                'message' => 'You cannot use this Coupon code',
            ];
            return $response;
        }

        // 2. check coupon start date & expiry date
        if ($currentDateTime > $coupon->start_date) {
            if (date('Y-m-d', strtotime($currentDateTime)) > $coupon->expiry_date) {
                $response = [
                    'status' => 'failure',
                    'message' => 'This Coupon code is already expired',
                ];
                return $response;
            }
        } else {
            $response = [
                'status' => 'failure',
                'message' => 'You cannot use this Coupon code',
            ];
            return $response;
        }

        // 3. check total coupon usage
        if ($coupon->max_no_of_usage > 0) {
            if (count($coupon->couponUsageTotal) >= $coupon->max_no_of_usage) {
                $response = [
                    'status' => 'failure',
                    'message' => 'You cannot use this Coupon code anymore',
                ];
                return $response;
            }
        }

        // 4. cart details fetch
        if (auth()->guard('web')->check()) {
            $cartContent = Cart::where('user_id', auth()->guard('web')->user()->id)->where('save_for_later', 0)->get();

            if (empty($cartContent) || count($cartContent) == 0) {
                $response = [
                    'status' => 'failure',
                    'message' => 'Something happened',
                ];
                return $response;
            }
        } else {
            if (!empty($_COOKIE['_cart-token'])) {
                $token = $_COOKIE['_cart-token'];
                $cartContent = Cart::where('guest_token', $token)->where('save_for_later', 0)->get();
            } else {
                $response = [
                    'status' => 'failure',
                    'message' => 'Something happened',
                ];
                return $response;
            }
        }
        $cartData = cartDetails($cartContent);
        if ($cartData['status'] == "failure") {
            $response = [
                'status' => 'failure',
                'message' => $cartData['message'],
            ];
            return $response;
        }


        // 5. check user coupon usage
        if ($coupon->user_max_no_of_usage > 0) {
            // logged in user
            if (auth()->guard('web')->check()) {
                // $usage_count = CouponUsage::where('user_id', auth()->guard('web')->user()->id)->count();
                $usage_count = CouponUsage::join('orders', 'orders.id', '=', 'coupon_usages.order_id')
                    ->where('coupon_usages.coupon_id', $coupon->id)
                    ->where('orders.user_id', auth()->guard('web')->user()->id)
                    ->count();
            }
            // guest user
            else {
                if (!empty($_COOKIE['_cart-token'])) {
                    $token = $_COOKIE['_cart-token'];
                    // $usage_count = CouponUsage::where('guest_token', $token)->count();
                    $usage_count = CouponUsage::join('orders', 'orders.id', '=', 'coupon_usages.order_id')
                        ->where('coupon_usages.coupon_id', $coupon->id)
                        ->where('orders.guest_token', $token)
                        ->count();
                } else {
                    $response = [
                        'status' => 'failure',
                        'message' => 'Something happened',
                    ];
                    return $response;
                }
            }

            // redirection
            if ($usage_count >= $coupon->user_max_no_of_usage) {
                $response = [
                    'status' => 'failure',
                    'message' => 'You cannot use this Coupon code anymore',
                ];
                return $response;
            }
        }


        // 6. check coupon products
        if (count($coupon->couponProducts) > 0) {
            $matchingProducts = [];
            // check for any matching product in cart
            foreach($cartContent as $cartProduct) {
                $checkMatchingProduct = CouponProduct::where('coupon_id', $coupon->id)->where('product_id', $cartProduct->product_id)->first();

                if (!empty($checkMatchingProduct)) {
                    $matchingProducts[] = $cartProduct->product_id;
                }
            }

            // dd($matchingProducts);

            // if no products match with coupon products
            if (count($matchingProducts) == 0) {
                $response = [
                    'status' => 'failure',
                    'message' => 'This Coupon code is not applicable to the products in your cart',
                ];
                return $response;
            }

            // if partial products match with coupon products
            if (count($matchingProducts) != count($cartContent)) {
                $response = [
                    'status' => 'failure',
                    'message' => 'This Coupon code matches only with some of the products in your cart',
                ];
                return $response;
            }
        }


        // 7. check minimum cart amount to check if coupon is applicable
        // check if minimum cart amount has to be maintained
        if (count($coupon->minimumCartAmount) > 0) {
            // fetch amount as per currency
            $minimumCartAmountDetails = CouponMinimumCartAmount::where('coupon_id', $coupon->id)->where('currency_id', $cartData['currencyId'])->first();

            if (empty($minimumCartAmountDetails)) {
                $response = [
                    'status' => 'failure',
                    'message' => 'You cannot use this Coupon code',
                ];
                return $response;
            }

            // comparing
            if ($minimumCartAmountDetails->minimum_cart_amount > $cartData['totalCartAmount']) {
                $comparisonAmount = (int) $minimumCartAmountDetails->minimum_cart_amount - $cartData['totalCartAmount'];

                $respMessage = 'Please add '.$cartData['currencyIcon'].' '.$comparisonAmount.' more to cart';

                $response = [
                    'status' => 'failure',
                    'message' => $respMessage,
                ];
                return $response;
            }
        }


        // 8. check coupon discount
        // 8.1 no coupon discount available
        if (count($coupon->couponDiscount) == 0) {
            $response = [
                'status' => 'failure',
                'message' => 'You cannot use this Coupon code',
            ];
            return $response;
        }
        // 8.2 checking for discount as per currency
        if (count($coupon->couponDiscount) > 0) {
            $currencyData = ipToCurrency();

            $data = CouponDiscount::where('coupon_id', $coupon->id)->where('currency_id', $currencyData->currency_id)->first();

            if (empty($data)) {
                $response = [
                    'status' => 'failure',
                    'message' => 'You cannot use this Coupon code',
                ];
                return $response;
            }
        }


        // 9. apply coupon
        foreach($cartContent as $cartItem) {
            $cartUpdate = Cart::findOrFail($cartItem->id);
            $cartUpdate->coupon_code = $coupon->id;
            $cartUpdate->save();
        }

        $response = [
            'status' => 'success',
            'message' => 'Coupon applied successfully',
        ];
        return $response;
    }

    public function remove(object $cartData) : array
    {
        // remove coupon
        foreach($cartData as $cartItem) {
            $cartUpdate = Cart::findOrFail($cartItem->id);
            $cartUpdate->coupon_code = 0;
            $cartUpdate->save();
        }

        $response = [
            'status' => 'success',
            'message' => 'Coupon removed successfully',
        ];
        return $response;
    }

    public function listAll(string $keyword)
    {
        $query = Coupon::query();

        $query->when($keyword, function($query) use ($keyword) {
            $query->where('name', 'like', '%'.$keyword.'%')
            ->orWhere('code', 'like', '%'.$keyword.'%')
            ->orWhere('max_no_of_usage', 'like', '%'.$keyword.'%')
            ->orWhere('user_max_no_of_usage', 'like', '%'.$keyword.'%');
        });

        $data = $query->orderBy('position')->paginate(25);

        $response = [
            'status' => 'success',
            'message' => 'Coupon data found',
            'data' => $data
        ];
        return $response;
    }

    public function listPublic()
    {
        $data = Coupon::where('type', 1)->orderBy('position')->get();

        $resp = [];
        if (count($data) > 0) {
            foreach ($data as $key => $value) {
                $discounts = $value->couponDiscount;
                $currencyData = ipToCurrency();
                $currencyId = $currencyData->currency_id;
                $currencyEntity = $currencyData->currencyDetails->entity;

                foreach($discounts as $discount) {
                    if ($discount->currency_id == $currencyId) {
                        $discountType = $discount->discount_type;
                        $discountAmount = $discount->discount_amount;
                    }
                }

                if ($discountType == 1) {
                    $discounthtml = 
                    'Flat <span class="currency-icon">'.$currencyEntity.'</span><span class="amount">'.indianMoneyFormat($discountAmount).'</span> Off';
                } else {
                    $discounthtml = $discountAmount.'% Off';
                }

                $resp[] = [
                    'id' => $value->id,
                    'code' => $value->code,
                    'details' => $value->details,
                    'discountHtml' => $discounthtml,
                ];
            }
        }

        $response = [
            'status' => 'success',
            'message' => 'Coupon data found',
            'data' => $resp
        ];
        return $response;
    }

    public function create(array $data)
    {
        DB::beginTransaction();

        try {
            // dd($data);
            $coupon = new Coupon();
            $coupon->name = $data['name'];
            $coupon->code = $data['code'];
            $coupon->max_no_of_usage = $data['max_no_of_usage'];
            $coupon->user_max_no_of_usage = $data['user_max_no_of_usage'];
            $coupon->type = 1;
            $coupon->start_date = $data['start_date'];
            $coupon->expiry_date = $data['expiry_date'];
            $coupon->position = positionSet('coupons');
            $coupon->save();

            foreach($data['currency_id'] as $dIndex => $currencyId) {
                $discount = new CouponDiscount();
                $discount->coupon_id = $coupon->id;
                $discount->currency_id = $currencyId;
                $discount->discount_type = $data['discount_type'][$dIndex];
                $discount->discount_amount = $data['discount_amount'][$dIndex];
                $discount->save();

                if (!empty($data['minimum_cart_amount'][$dIndex])) {
                    $minimumCAmount = new CouponMinimumCartAmount();
                    $minimumCAmount->coupon_id = $coupon->id;
                    $minimumCAmount->currency_id = $currencyId;
                    $minimumCAmount->minimum_cart_amount = $data['minimum_cart_amount'][$dIndex];
                    $minimumCAmount->save();
                }
            }

            if (!empty($data['duallistbox']) && count($data['duallistbox']) > 0) {
                foreach($data['duallistbox'] as $productId) {
                    $cProduct = new CouponProduct();
                    $cProduct->coupon_id = $coupon->id;
                    $cProduct->product_id = $productId;
                    $cProduct->save();
                }
            }

            DB::commit();

            $response = [
                'status' => 'success',
                'message' => 'Coupon created successfully'
            ];
            return $response;
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;

            $response = [
                'status' => 'failure',
                'message' => 'Something happened'
            ];
        }
    }

    public function detail(int $id)
    {
        $data = Coupon::findOrFail($id);

        if ($data) {
            $response = [
                'status' => 'success',
                'message' => 'Coupon data found',
                'data' => $data
            ];
        } else {
            $response = [
                'status' => 'failure',
                'message' => 'Coupon data invalid',
            ];
        }

        return $response;

    }

    public function update(array $data)
    {
        DB::beginTransaction();

        try {
            // dd($data);

            $coupon = Coupon::findOrFail($data['id']);
            $coupon->name = $data['name'];
            $coupon->code = $data['code'];
            $coupon->max_no_of_usage = $data['max_no_of_usage'];
            $coupon->user_max_no_of_usage = $data['user_max_no_of_usage'];
            $coupon->type = 1;
            $coupon->start_date = $data['start_date'];
            $coupon->expiry_date = $data['expiry_date'];
            $coupon->position = positionSet('coupons');
            $coupon->save();

            // delete older
            CouponDiscount::where('coupon_id', $data['id'])->delete();
            CouponMinimumCartAmount::where('coupon_id', $data['id'])->delete();

            foreach($data['currency_id'] as $dIndex => $currencyId) {
                $discount = new CouponDiscount();
                $discount->coupon_id = $coupon->id;
                $discount->currency_id = $currencyId;
                $discount->discount_type = $data['discount_type'][$dIndex];
                $discount->discount_amount = $data['discount_amount'][$dIndex];
                $discount->save();

                if (!empty($data['minimum_cart_amount'][$dIndex])) {
                    // // delete older

                    $minimumCAmount = new CouponMinimumCartAmount();
                    $minimumCAmount->coupon_id = $coupon->id;
                    $minimumCAmount->currency_id = $currencyId;
                    $minimumCAmount->minimum_cart_amount = $data['minimum_cart_amount'][$dIndex];
                    $minimumCAmount->save();
                }
            }

            if (!empty($data['duallistbox']) && count($data['duallistbox']) > 0) {
                // delete older
                CouponProduct::where('coupon_id', $data['id'])->delete();

                foreach($data['duallistbox'] as $productId) {
                    $cProduct = new CouponProduct();
                    $cProduct->coupon_id = $coupon->id;
                    $cProduct->product_id = $productId;
                    $cProduct->save();
                }
            }

            DB::commit();

            $response = [
                'status' => 'success',
                'message' => 'Coupon updated successfully'
            ];
            return $response;
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;

            $response = [
                'status' => 'failure',
                'message' => 'Something happened'
            ];
        }
    }

    public function delete(int $id)
    {
        DB::beginTransaction();

        try {
            Coupon::where('id', $id)->delete();
            CouponDiscount::where('coupon_id', $id)->delete();
            CouponMinimumCartAmount::where('coupon_id', $id)->delete();
            CouponProduct::where('coupon_id', $id)->delete();

            DB::commit();

            $response = [
                'status' => 'success',
                'message' => 'Coupon deleted successfully'
            ];
            return $response;
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;

            $response = [
                'status' => 'failure',
                'message' => 'Something happened'
            ];
        }
    }

    public function status(int $id)
    {
        $data = Coupon::findOrFail($id);
        $data->status = ($data->status == 1) ? 0 : 1;
        $data->update();

        $response = [
            'status' => 200,
            'message' => 'Status updated'
        ];
        return $response;
    }

    public function position(array $positions)
    {
        $count = 1;
        foreach($positions as $position) {
            $data = Coupon::findOrFail($position);
            $data->position = $count;
            $data->save();

            $count++;
        }

        $response = [
            'status' => 200,
            'message' => 'Position updated'
        ];
        return $response;
    }
}
