<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Interfaces\CouponInterface;
use App\Interfaces\CartInterface;

use App\Models\SeoPage;
use App\Models\ProductVariation;

class CartController extends Controller
{
    private CouponInterface $couponRepository;
    private CartInterface $cartRepository;

    public function __construct(CouponInterface $couponRepository, CartInterface $cartRepository)
    {
        $this->couponRepository = $couponRepository;
        $this->cartRepository = $cartRepository;
    }

    public function index(Request $request)
    {
        // cart data fetch
        $resp = $this->cartRepository->fetch();

        // if data
        if ($resp['status'] == "success") {
            // if product exists in cart
            if(count($resp['data']) > 0) {
                // coupon validation check
                if ($resp['data'][0]->coupon_code != 0) {
                    $couponResp = $this->couponRepository->check($resp['data'][0]->couponDetails->code);

                    // if failure
                    if ($couponResp['status'] == "failure") {
                        // remove coupon
                        $this->couponRepository->remove($resp['data']);
                    }
                }
            }
        }

        $seo = SeoPage::where('page', 'cart')->first();
        return view('front.cart.index', compact('seo'));
    }

    public function indexJson(Request $request)
    {
        $userId = 0;
        if (auth()->guard('web')->check()) {
            $userId = auth()->guard('web')->user()->id;
        }

        $resp = $this->cartRepository->fetchAjax($userId);

        // if cart data found
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
                    $imgPath = asset('uploads/static-front-missing-image/product.svg');
                }

                $pricingDetails = productVariationPricing($cartItem->productDetails, $cartItem->product_variation_id ?? 0);
                // $pricingDetails = productVariationPricing($cartItem->productDetails, explode(',', $cartItem->product_variation_id));
                $currencyEntity = $pricingDetails['currency_entity'];
                $sellingPrice = $pricingDetails['selling_price'];
                $mrp = $pricingDetails['mrp'];
                $discount = discountCalculate($sellingPrice, $mrp);

                // variation
                // $variationDetail = ($cartItem->product_variation_id != 0) ? $cartItem->variationDetail->title : '';
                $variationDetailTitles = [];
                if ($cartItem->product_variation_id != NULL) {
                    $variationChildIds = explode(',', $cartItem->product_variation_id);
                    
                    foreach ($variationChildIds as $childId) {
                        $variationDetail = ProductVariation::find($childId);

                        if ($variationDetail) {
                            $variationDetailTitles[] = $variationDetail->variationOption->value;
                        }
                    }
                }

                $cartProductsList[] = [
                    'cartId' => $cartItem->id,
                    'image' => $imgPath,
                    'title' => $cartItem->productDetails->title,
                    'slug' => $cartItem->productDetails->slug,
                    'variationData' => implode(' ', $variationDetailTitles),
                    // 'variationData' => implode(' ', $variationDetailTitles),
                    'link' => route('front.product.detail', $cartItem->productDetails->slug),
                    'removeLink' => route('front.cart.remove', $cartItem->id),
                    'qty' => $cartItem->qty,
                    'currencyEntity' => $currencyEntity,
                    'sellingPrice' => $sellingPrice,
                    'mrp' => $mrp,
                    'discount' => $discount,
                    'tteesstt' => $pricingDetails
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

    public function remove(Request $request, $id)
    {
        $resp = $this->cartRepository->remove($id);

        if (auth()->guard('web')->check()) {
            $cartCount = $this->cartRepository->countLoggedInUser(auth()->guard('web')->user()->id)['data'];
        } else {
            $cartCount = $this->cartRepository->countGuestUser()['data'];
        }

        if ($resp['status'] == "success") {
            return response()->json([
                'status' => 200,
                'message' => $resp['message'],
                'data' => $cartCount
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => $resp['message']
            ]);
        }
        // return redirect()->back()->with($resp['status'], $resp['message'])->withInput($request->all());
    }

    public function save(Request $request, $id)
    {
        $userId = 0;
        if (auth()->guard('web')->check()) {
            $resp = $this->cartRepository->saveToggle($id);

            if (auth()->guard('web')->check()) {
                $cartCount = $this->cartRepository->countLoggedInUser(auth()->guard('web')->user()->id)['data'];
            } else {
                $cartCount = $this->cartRepository->countGuestUser()['data'];
            }

            if ($resp['status'] == "success") {
                return response()->json([
                    'status' => 200,
                    'message' => $resp['message'],
                    'data' => $cartCount
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => $resp['message']
                ]);
            }
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Login to continue',
                'type' => 'login',
            ]);
        }
    }

    public function qtyUpdate(Request $request)
    {
        $maxQty = applicationSettings()->cart_max_product_qty;

        $validate = Validator::make($request->all(), [
            "id" => "required|integer|min:1",
            "qty" => "required|integer|min:1|max:".$maxQty,
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validate->errors()->first()
            ]);
        }

        $resp = $this->cartRepository->qtyUpdate($request->id, $request->qty);

        if ($resp['status'] == "success") {
            return response()->json([
                'status' => 200,
                'message' => $resp['message']
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => $resp['message']
            ]);
        }

        // return redirect()->route('front.cart.index')->with($resp['status'], $resp['message'])->withInput($request->all());
    }

    public function savedIndexJson(Request $request)
    {
        $userId = 0;
        if (auth()->guard('web')->check()) {
            $userId = auth()->guard('web')->user()->id;
        }

        $resp = $this->cartRepository->savedItemsFetch($userId);

        // if data found
        if ($resp['status'] == "success") {
            $cartProductsList = [];
            foreach ($resp['data'] as $key => $cartItem) {
                if (count($cartItem->productDetails->frontImageDetails) > 0) {
                    $imgPath = asset($cartItem->productDetails->frontImageDetails[0]->img_large);
                } else {
                    $imgPath = asset('uploads/static-front-missing-image/product.svg');
                }

                // checking status to show in frontend option - Hide/ Draft
                if($cartItem->productDetails->statusDetail->show_in_frontend == 0) continue;

                // $pricingDetails = productPricing($cartItem->productDetails);
                $pricingDetails = productVariationPricing($cartItem->productDetails, $cartItem->product_variation_id);
                $currencyEntity = $pricingDetails['currency_entity'];
                $sellingPrice = $pricingDetails['selling_price'];
                $mrp = $pricingDetails['mrp'];
                $discount = discountCalculate($sellingPrice, $mrp);

                // variation
                $variationDetail = ($cartItem->product_variation_id != 0) ? $cartItem->variationDetail->title : '';

                $cartProductsList[] = [
                    'cartId' => $cartItem->id,
                    'image' => $imgPath,
                    'title' => $cartItem->productDetails->title,
                    'slug' => $cartItem->productDetails->slug,
                    'variationData' => $variationDetail,
                    'link' => route('front.product.detail', $cartItem->productDetails->slug),
                    'removeLink' => route('front.cart.remove', $cartItem->id),
                    'qty' => $cartItem->qty,
                    'currencyEntity' => $currencyEntity,
                    'sellingPrice' => $sellingPrice,
                    'mrp' => $mrp,
                    'discount' => $discount,
                    'purchase' => $cartItem->productDetails->statusDetail->purchase,
                    'status' => $cartItem->productDetails->statusDetail->name
                ];
            }

            if (count($cartProductsList) > 0) {
                return response()->json([
                    'status' => 200,
                    'message' => $resp['message'],
                    'data' => $cartProductsList
                ]);
            }
        }

        return response()->json([
            'status' => 400,
            'message' => $resp['message']
        ]);
    }
}
