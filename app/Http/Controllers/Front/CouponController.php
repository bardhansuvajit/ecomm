<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Interfaces\CouponInterface;
use App\Interfaces\CartInterface;

class CouponController extends Controller
{
    private CouponInterface $couponRepository;
    private CartInterface $cartRepository;

    public function __construct(CouponInterface $couponRepository, CartInterface $cartRepository)
    {
        $this->couponRepository = $couponRepository;
        $this->cartRepository = $cartRepository;
    }

    public function check(Request $request)
    {
        $request->validate([
            'coupon' => 'required|string|min:3|exists:coupons,code'
        ]);

        $resp = $this->couponRepository->check($request->coupon);
        return redirect()->back()->with($resp['status'], $resp['message'])->withInput($request->all());
    }

    public function checkJson(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'coupon' => 'required|string|min:3|exists:coupons,code'
        ], [
            'coupon.*' => 'Please enter a valid coupon'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validate->errors()->first(),
            ]);
        }

        $resp = $this->couponRepository->check($request->coupon);

        if ($resp['status'] == "success") {
            return response()->json([
                'status' => 200,
                'message' => $resp['message'],
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => $resp['message'],
            ]);
        }
        
        // return redirect()->back()->with($resp['status'], $resp['message'])->withInput($request->all());
    }

    public function remove(Request $request)
    {
        // cart data fetch
        $resp = $this->cartRepository->fetch();

        // if data
        if ($resp['status'] == "success") {
            // remove coupon
            $resp = $this->couponRepository->remove($resp['data']);

            if ($resp['status'] == "success") {
                return response()->json([
                    'status' => 200,
                    'message' => $resp['message'],
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => $resp['message'],
                ]);
            }
        } else {
            return response()->json([
                'status' => 400,
                'message' => $resp['message'],
            ]);
        }

        // return redirect()->back()->with($resp['status'], $resp['message'])->withInput($request->all());
    }

    public function list(Request $request)
    {
        $resp = $this->couponRepository->listPublic();

        if ($resp['status'] == "success") {
            return response()->json([
                'status' => 200,
                'message' => 'Coupons found',
                'data' => $resp['data']
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => $resp['message'],
            ]);
        }

    }
}
