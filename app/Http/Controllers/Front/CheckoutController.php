<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Interfaces\CouponInterface;
use App\Interfaces\CartInterface;
use App\Interfaces\OrderInterface;
use App\Interfaces\PaymentMethodInterface;
use App\Interfaces\CountryInterface;
use App\Interfaces\StateInterface;
use App\Interfaces\AuthInterface;
use App\Interfaces\UserAddressInterface;

use App\Models\SeoPage;

class CheckoutController extends Controller
{
    private CouponInterface $couponRepository;
    private CartInterface $cartRepository;
    private OrderInterface $orderRepository;
    private PaymentMethodInterface $paymentMethodRepository;
    private CountryInterface $countryRepository;
    private StateInterface $stateRepository;
    private AuthInterface $authRepository;
    private UserAddressInterface $userAddressRepository;

    public function __construct(CouponInterface $couponRepository, CartInterface $cartRepository, OrderInterface $orderRepository, PaymentMethodInterface $paymentMethodRepository, CountryInterface $countryRepository, StateInterface $stateRepository, AuthInterface $authRepository, UserAddressInterface $userAddressRepository)
    {
        $this->couponRepository = $couponRepository;
        $this->cartRepository = $cartRepository;
        $this->orderRepository = $orderRepository;
        $this->paymentMethodRepository = $paymentMethodRepository;
        $this->countryRepository = $countryRepository;
        $this->stateRepository = $stateRepository;
        $this->authRepository = $authRepository;
        $this->userAddressRepository = $userAddressRepository;
    }

    public function index(Request $request)
    {
        $mobileCheck = [];
        // cart data fetch
        $resp = $this->cartRepository->fetch();

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

            $data = (object) [];
            $data->seo = SeoPage::where('page', 'checkout')->first();
            $data->payment_methods = $this->paymentMethodRepository->listActive()['data'];
            // $data->countries = $this->countryRepository->listShippingOnly()['data'];

            // when user not logged in, cehcking with entered mobile number
            if (request()->input('mobile_no')) {
                $mobileCheck = $this->authRepository->checkMobile(request()->input('mobile_no'));
            }

            // when user is logged in, fetch saved address
            if (auth()->guard('web')->check()) {
                $data->deliveryAddresses = $this->userAddressRepository->fetchDeliveryAddressesByUser(auth()->guard('web')->user()->id);
                $data->billingAddresses = $this->userAddressRepository->fetchBillingAddressesByUser(auth()->guard('web')->user()->id);
                $data->shippingCountries = $this->countryRepository->listShippingOnly();
            }
            $data->states = $this->stateRepository->stateListByCountry(101)['data'];

            return view('front.checkout.index', compact('data', 'mobileCheck'));

        } else {
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'payment_method' => 'required|string|min:2|max:255',
            'billing_same_as_shipping' => 'required|string|min:4|max:5|in:true,false',
            'razorpay_payment_id' => 'nullable|string|min:4|max:200',
        ]);

        if (auth()->guard('web')->check()) {
            $data = $request->all() + [
                'user_id' => auth()->guard('web')->user()->id
            ];

            $resp = $this->orderRepository->create($data);

            // if data
            if ($resp['status'] == "success") {
                return redirect()->route('front.checkout.complete', ['order' => $resp['data']->order_no]);
            } else {
                return redirect()->back()->with($resp['status'], $resp['message'])->withInput($request->all());
            }
        } else {
            return redirect()->back()->with('failure', 'Something happened')->withInput($request->all());
        }
    }

    public function complete(Request $request)
    {
        if (auth()->guard('web')->check()) {
            $userId = auth()->guard('web')->user()->id;
            $resp = $this->orderRepository->findByorderNo($request->order, $userId);

            // if data
            if ($resp['status'] == "success") {
                $data = $resp['data'];
                return view('front.checkout.complete', compact('data'));
            } else {
                return redirect()->route('front.error.404');
            }
        } else {
            return redirect()->route('front.error.404');
        }
    }

    public function loginCheck(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'mobile_no' => 'required|integer|min:1|digits:10',
            'password' => 'required|string|min:2|max:30',
            'type' => 'required|in:login,register',
        ]);

        if ($request->type == "login") {
            $creds = $request->only(['mobile_no', 'password']);
            // $creds = ['phone' => $request->mobile_no, 'password' => $request->password];
            $resp = $this->authRepository->check($creds);
        } else {
            $creds = ['phone' => $request->mobile_no, 'password' => $request->password];
            $resp = $this->authRepository->create($creds);
            // $resp = $this->authRepository->create($request->all());
        }
        return redirect()->route('front.checkout.index')->with($resp['status'], $resp['message']);
    }

    public function userDetail(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'first_name' => 'required|string|min:2|max:50',
            'last_name' => 'required|string|min:2|max:50',
            'email' => 'required|email|min:2|max:130',
            // 'email' => 'required|email|min:2|max:130|unique:users,email',
        ]);

        if (auth()->guard('web')->check()) {
            $resp = $this->authRepository->update($request->all(), auth()->guard('web')->user()->id);

            return redirect()->route('front.checkout.index')->with($resp['status'], $resp['message']);
        } else {
            return redirect()->route('front.checkout.index')->with('failure', 'Something happened');
        }
    }

    public function removeBillingAddressAll(Request $request)
    {
        if (auth()->guard('web')->check()) {
            $resp = $this->userAddressRepository->removeBillingAddressAll(auth()->guard('web')->user()->id);

            return redirect()->route('front.checkout.index')->with($resp['status'], 'Billing address updated');
        } else {
            return redirect()->route('front.checkout.index')->with('failure', 'Something happened');
        }
    }

}
