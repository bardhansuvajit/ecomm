@extends('front.layout.app')

@section('page-title', 'Checkout')

@section('section')
<section class="cart-products mb-3" id="checkout-address">
    <div class="row">

        <div class="col-md-8">
            <div class="saved-for-later">
                <div class="row">
                    <div class="col-12">
                        <p class="display-6">Address</p>
                    </div>

                    <div class="col-12">
                        <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('front.cart.index') }}">Cart</a></li>
                                <li class="breadcrumb-item active fw-600" aria-current="page">Address</li>
                                <li class="breadcrumb-item"><a href="{{ route('front.checkout.index') }}">Payment</a></li>
                            </ol>
                        </nav>
                    </div>

                    {{-- login/ signup check --}}
                    <div class="col-12">
                        <div class="login-container">
                            @if (auth()->guard('web')->check())
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-10">
                                                <div class="single-address">
                                                    <div class="short_address">
                                                        <p class="small text-muted mb-1">Logged in as</p>
                                                        <span class="delivery_person">{{ auth()->guard('web')->user()->first_name.' '.auth()->guard('web')->user()->last_name }}</span>
                                                        <span class="delivery_contact">{{ auth()->guard('web')->user()->mobile_no }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-2 text-end pt-2">
                                                <a href="{{ route('front.user.logout') }}" class="small fw-600" onclick="event.preventDefault();document.getElementById('logout-form').submit();">LOGOUT</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="card p-1">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <h5 class="">Login/ Signup</h5>
                                                <p class="small text-muted">Login now to unlock more possibilites like Saved address, Tracking orders, Wishlisting items, share Reviews etc.</p>
                                            </div>
    
                                            <div class="col-12 col-md-6 mb-3">
                                                <form action="{{ route('api.user.check.mobile') }}" id="loginCheckForm" method="post">@csrf
                                                    <div class="form-floating mb-3">
                                                        <input type="number" class="form-control form-control-sm" id="loginMobileNumber" placeholder="9876XXXXX0" name="mobile_no" value="{{ old('mobile_no') }}" autocomplete="tel" autofocus required>
                                                        <label for="loginMobileNumber">Mobile number *</label>
                                                    </div>
    
                                                    <div id="loginResp"></div>
    
                                                    <button class="btn btn-primary">
                                                        Continue
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- show address related options only when logged in --}}
                    @if(auth()->guard('web')->check())
                    <div class="col-12">
                        <div class="card mt-4">
                            <div class="card-body">
                                {{-- <div class="row"> --}}
                                    @if (count($data->address) > 0)
                                        {{-- <div class="col-12"> --}}
                                            <p class="small text-muted">Delivery address selected. <a href="#addNewAddress" data-bs-toggle="modal">Change address ?</a></p>
                                        {{-- </div> --}}
                                    @else
                                        {{-- <div class="col-12"> --}}
                                            <p class="small text-muted">No address found. Enter your delivery address</p>
                                        {{-- </div> --}}
                                    @endif

                                    <div id="address_initials">
                                        <div class="row mx-0">
                                            <div class="col-12 px-0">
                                                @foreach ($data->address as $addressKey => $addressVal)
                                                <div class="single-address">
                                                    <div class="custom-control custom-radio ps-1">
                                                        <input type="radio" id="selectDelivery{{$addressKey}}" class="custom-control-input address-select" value="{{$addressVal->id}}" name="shippingaddress" {{ ($addressKey == 0) ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="selectDelivery{{$addressKey}}">
                                                            <div class="short_address">
                                                                <span class="delivery_person">{{$addressVal->full_name}}</span>
                                                                <span class="delivery_contact">{{$addressVal->mobile_no}}</span>
                                                                @if ($addressVal->type != 'not specified')
                                                                    <span class="address_type badge">{{strtoupper($addressVal->type)}}</span>
                                                                @endif
                                                            </div>
                                                            <div class="detailed_address">
                                                                <p class="deliveryAddress">
                                                                    {{$addressVal->street_address}},
                                                                    {{$addressVal->city}},
                                                                    {{$addressVal->pincode}},
                                                                    {{$addressVal->locality}},
                                                                    {{$addressVal->state}}
                                                                </p>
                                                            </div>
                                                        </label>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    {{-- if no address found for this account --}}
                                    @if (count($data->address) == 0)
                                    <div class="row">
                                        <div class="col-12"><p class="text-muted fw-700">User information</p></div>

                                        <div class="col-12 col-md-6 mb-3">
                                            <div class="form-floating">
                                                <input type="text" class="form-control form-control-sm @error('full_name') is-invalid @enderror" id="full_name" placeholder="Full name" name="full_name" value="{{ auth()->guard('web')->check() ? auth()->guard('web')->user()->first_name.' '.auth()->guard('web')->user()->last_name : old('full_name') }}" autocomplete="name" maxlength="70" form="addressStore" required>

                                                <label for="full_name">Full name *</label>
                                                @error('full_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6 mb-3">
                                            <div class="form-floating">
                                                <input type="tel" class="form-control form-control-sm @error('mobile_number') is-invalid @enderror" id="floatingNumber" placeholder="9876XXXXX0" name="mobile_number" value="{{ auth()->guard('web')->check() ? auth()->guard('web')->user()->mobile_no : old('mobile_number') }}" autocomplete="tel" form="addressStore" required>
                                                <label for="floatingNumber">Mobile number *</label>
                                                @error('mobile_number')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6 mb-3">
                                            <div class="form-floating">
                                                <input type="email" class="form-control form-control-sm @error('email') is-invalid @enderror" id="floatingEmail" placeholder="name@example.com" name="email" value="{{ auth()->guard('web')->check() ? auth()->guard('web')->user()->email : old('email') }}" autocomplete="email" maxlength="70" form="addressStore">
                                                <label for="floatingEmail">Email address</label>
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-12"><p class="text-muted fw-700">Address information</p></div>

                                        <div class="col-12 col-md-6 mb-3">
                                            <div class="form-floating">
                                                <input type="number" class="pincode form-control form-control-sm @error('pincode') is-invalid @enderror" id="pincode" placeholder="XXXXXX" name="pincode" value="{{ old('pincode') ? old('pincode') : ($data->user_pincode ? $data->user_pincode->pincode : '') }}" autocomplete="postal-code" form="addressStore" required>
                                                <label for="pincode">Pincode *</label>
                                                <span class="pincode-loader"></span>
                                                @error('pincode')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6 mb-3">
                                            <div class="form-floating">
                                                <input type="text" class="form-control form-control-sm @error('landmark') is-invalid @enderror" id="landmark" placeholder="Enter landmark" name="landmark" value="{{ old('landmark') }}" autocomplete="landmark" maxlength="70" form="addressStore">
                                                <label for="landmark">Landmark (optional)</label>
                                                @error('landmark')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-12 mb-3">
                                            <div class="form-floating">
                                                <textarea name="street_address" class="form-control form-control-sm @error('street_address') is-invalid @enderror" placeholder="Enter street address" id="street_address" style="min-height: 70px" form="addressStore">{{old('street_address')}}</textarea>
                                                <label for="street_address">Street address *</label>
                                                @error('street_address')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-4 mb-3">
                                            <div class="form-floating">
                                                <select class="form-select form-select-sm locality" name="locality" id="locality" form="addressStore">
                                                    @if (old('locality'))
                                                        <option value="{{old('locality')}}" selected>{{old('locality')}}</option>
                                                    @else
                                                        @if ($data->user_pincode)
                                                            <option value="{{$data->user_pincode->locality}}" selected>{{$data->user_pincode->locality}}</option>
                                                        @else
                                                            <option>Select pincode first</option>
                                                        @endif
                                                    @endif
                                                </select>
                                                <label for="locality">Locality *</label>

                                                @error('locality')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-4 mb-3">
                                            <div class="form-floating">
                                                <input type="text" class="city form-control form-control-sm @error('city') is-invalid @enderror" id="city" placeholder="Enter city" name="city" value="{{ old('city') ? old('city') : ($data->user_pincode ? $data->user_pincode->city : '') }}" autocomplete="city" form="addressStore">
                                                <label for="city">City/ District/ Town *</label>
                                                @error('city')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-4 mb-3">
                                            <div class="form-floating">
                                                <input type="text" class="state form-control form-control-sm @error('state') is-invalid @enderror" id="state" placeholder="Enter state" name="state" value="{{ old('state') ? old('state') : ($data->user_pincode ? $data->user_pincode->state : '') }}" autocomplete="state" form="addressStore">
                                                <label for="state">State *</label>
                                                @error('state')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <input type="hidden" class="country" name="country" id="country" value="{{ ( old('country') ? old('country') : ($data->user_pincode ? $data->user_pincode->country : '') ) }}" form="addressStore" autocomplete="country">
                                    </div>
                                    @endif
                                {{-- </div> --}}
                            </div>
                        </div>
                    </div>
                    @endif

                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card" id="checkout_card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h5 class="mb-3">Cart review</h5>
                        {{-- <a href="" class="small text-muted">Show all</a> --}}
                    </div>

                    <div class="row">
                        <div class="col-12">
                        @php
                            $totalCartPrice = $totalQty = $singlePrice = $totalCartDiscount = $couponDiscount = $finalPayment = 0;
                        @endphp

                        @foreach ($data->cart as $cartKey => $cart)
                        <div class="card card-body border-0">
                            <div class="row">
                                <div class="col-md-2 col-4">
                                    <a href="{{ route('front.product.detail', $cart->productDetails->slug) }}" target="_blank">
                                        <div class="fixed-image-holder" style="height: 50px">
                                            <img src="{{ asset($cart->productDetails->imageDetails[0]->img_50) }}" alt="">
                                        </div>
                                    </a>
                                </div>

                                <div class="col-md-10 col-8">
                                    <p class="mb-0 d-inline-block">{{ $cart->productDetails->title }}</p>
                                    <div class="d-flex">
                                        <p class="small text-muted me-3 mb-0">Qty: <span class="fw-600 text-dark">{{$cart->qty}}</span></p>
                                        @if(!empty($cart->productDetails->offer_price))
                                            <p class="small sell-price mb-0">&#8377;{{number_format($cart->productDetails->offer_price)}}</p>
                                        @else
                                            <p class="small sell-price mb-0">&#8377;{{number_format($cart->productDetails->price)}}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-1">

                        @php
                            $singlePrice += (int) ($cart->productDetails->offer_price == 0.00) ? $cart->productDetails->price : $cart->productDetails->offer_price;

                            // total number of products in cart
                            $totalQty += (int) $cart->qty;

                            // calculate total cart discount
                            $totalCartDiscount += (int) (($cart->productDetails->offer_price == 0.00) ? 0 : ($cart->productDetails->price - $cart->productDetails->offer_price)) * $cart->qty;

                            // calculate total cart amount
                            $totalCartPrice += (int) $cart->productDetails->price * $cart->qty;

                            // final payment
                            $finalPayment += (int) (($cart->productDetails->offer_price == 0) ? $cart->productDetails->price : $cart->productDetails->offer_price) * $cart->qty;
                        @endphp

                        @endforeach

                        @php
                            // check for coupon, if coupon found
                            if ($data->cart[0]->coupon_code != 0) {
                                // if FLAT discount
                                if ($data->cart[0]->couponDetails->type == 2) {
                                    $couponDiscount = $data->cart[0]->couponDetails->amount;
                                }
                                // if PERCENTAGE discount
                                else {
                                    $couponDiscount = $finalPayment * ($data->cart[0]->couponDetails->amount / 100);
                                }
                            }

                            $finalPaymentWithoutCouponDiscount = $finalPayment;
                            $finalPayment = ceil($finalPayment - $couponDiscount);
                        @endphp
                        </div>
                    </div>
                    {{-- <div class="row">
                        <div class="col-6"><p class="text-muted">Total</p></div>
                        <div class="col-6 text-end"><p class=""> &#8377;{{number_format($totalCartPrice)}} </p></div>
                    </div> --}}
                    {{-- <div class="row">
                        <div class="col-6"><p class="text-muted">Discount</p></div>
                        <div class="col-6 text-end">
                            <p class="">
                                {{$totalCartDiscount > 0 ? '-' : ''}}
                                &#8377;{{number_format($totalCartDiscount)}}
                            </p>
                        </div>
                    </div> --}}
                    {{-- <div class="row delivery-details">
                        <div class="col-6"><p class="text-muted mb-0">Delivery</p></div>
                        @if ($userPincode)
                            <div class="col-6 text-end"><p class="mb-0"> FREE </p></div>
                            <div class="col-12">
                                <p class="small text-muted mb-0">
                                    Delivery at <strong>{{$userPincode->pincode}}</strong>
                                    <a href="javascript: void(0)" class="userPincodeOpen">Change?</a>
                                </p>
                            </div>
                        @else
                            <div class="col-6 text-end"><p class="mb-0 fw-600"> <a href="javascript: void(0)" class="text-danger userPincodeOpen">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-info"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                                Pincode
                            </a></p></div>
                        @endif
                    </div> --}}

                    {{-- <hr> --}}

                    <div class="row" id="subTotalRow">
                    @if ($data->cart[0]->coupon_code != 0)
                        <div class="col-6"><p class="text-muted">Sub-total</p></div>
                        <div class="col-6 text-end">
                            <p class="">
                                &#8377;{{number_format($finalPaymentWithoutCouponDiscount)}}
                            </p>
                        </div>
                    @endif
                    </div>

                    {{-- <div class="row">
                        <div class="col-12" id="couponStatus">
                            @if ($data->cart[0]->coupon_code == 0)
                                <div class="coupon-not-applied">
                                    <a data-bs-toggle="collapse" href="#couponCollapse">
                                        <p class="mb-2">I have a Voucher/ Coupon code</p>
                                    </a>
                                    <div class="coupon-code-container collapse" id="couponCollapse">
                                        <form action="{{ route('coupon.status') }}" method="get" id="couponCheck">
                                            <div class="input-group">
                                                <input type="text" class="form-control coupon-code" placeholder="Enter Voucher/ Coupon code" id="coupon" name="coupon" value="" maxlength="10">
                                                <span class="pincode-loader" style="right: 70px;"></span>
                                                <button class="btn btn-secondary" type="submit" id="couponCheckBtn">Apply</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <div class="coupon-applied">
                                    <div class="row mb-3">
                                        <div class="col-6"><p class="text-muted mb-0">Coupon Applied</p></div>
                                        @if ($data->cart[0]->couponDetails)
                                            <div class="col-6 text-end">
                                                <p class="mb-0 fw-600">
                                                    {!!
                                                        ($data->cart[0]->couponDetails->type == 1) ? $data->cart[0]->couponDetails->amount.'% OFF' : '&#8377;'.number_format($data->cart[0]->couponDetails->amount).' OFF'
                                                    !!}
                                                </p>
                                            </div>
                                            <div class="col-12">
                                                <p class="small text-muted mb-0">
                                                    {{$data->cart[0]->couponDetails->coupon_code}}
                                                    <a href="javascript: void(0)" onclick="couponRemove()">Remove?</a>
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div> --}}

                    <div class="row mt-2">
                        <div class="col-6"><p class="text-muted fw-600">Pay ({{$totalQty}} {{$totalQty == 1 ? 'item' : 'items'}})</p></div>
                        <div class="col-6 text-end">
                            <p class="fw-600">
                                &#8377;
                                <span id="finalAmountDisplay">{{number_format($finalPayment)}}</span>
                                <input type="hidden" name="finalAmountWTCoupon" value="{{$finalPaymentWithoutCouponDiscount}}">
                            </p>
                        </div>
                    </div>
                </div>

                <div class="card-footer checkout_redirect">
                    @if(auth()->guard('web')->check())
                        @if (count($data->address) > 0)
                            <a href="{{ route('front.checkout.index') }}" class="btn btn-primary address-button w-100">
                                Payment
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </a>
                        @else
                            <form action="{{ route('front.address.store') }}" id="addressStore" method="post">@csrf
                                <button class="btn btn-primary address-button w-100">
                                    Deliver here
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                                </button>
                            </form>
                        @endif
                    {{-- @else
                        <h2 class="text-primary p-2">Login to continue</h2> --}}
                    @endif
                </div>

                @if (auth()->guard('web')->check())
                    @if (count($data->address) > 0)
                        <p class="small text-muted mt-2 mb-0">Select delivery address &amp; goto Payment page</p>
                    @else
                        <p class="small text-muted mt-2 mb-0">Tap here to save address &amp; goto Payment page</p>
                    @endif
                @endif
            </div>
        </div>

    </div>
</section>

{{-- cart next page hightlight - only mobile --}}
{{-- <nav class="navbar fixed-bottom redirect_buttons_mobile">
    <div class="row gx-3 mx-0">
        <div class="col-6">
            <a href="javascript: void(0)" class="btn btn-secondary text-start w-100" id="mobile_checkout_info">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-info"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                &#8377;<span>{{number_format($finalPayment)}}</span>
            </a>
        </div>
        <div class="col-6">
            <a href="checkout" class="btn btn-primary text-end w-100">
                Payment
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </a>
        </div>
    </div>
</nav> --}}

{{-- add new address --}}
@include('front.modal.address-create')

@endsection

@section('script')
    <script src="{{ asset('./js/coupon-handler.js') }}"></script>

    <script>
        $('#mobile_checkout_info').on('click', function () {
            if ($("#checkout_card").css("display") == "none") {
                $("#checkout_card").css("display", "block");
                $("#checkout_card").removeClass("check_hide");
                $("#checkout_card").addClass("show");
            } else {
                $("#checkout_card").removeClass("show");
                $("#checkout_card").addClass("check_hide");
                setTimeout(() => {
                    $("#checkout_card").hide();
                }, 500);
            }
        });

        // pincode data fetch
        $('.pincode').on('keyup', function() {
            if ($('.pincode').val().length == 6) {
                postalPinCode($('.pincode').val());
            }
        });

        // focus on pincode on add new address modal shown
        $('#addNewAddress').on('shown.bs.modal', () => {
            setTimeout(() => {
                $('input[name="pincode"]').focus();
            }, 200);
        });

        /*
        // add new address
        $(document).on('submit', '#addressStoreForm', function(e) {
            e.preventDefault();
            $.ajax({
                url : $(this).attr('action'),
                method : $(this).attr('method'),
                data : {
                    _token: $('input[name="_token"]').val(),
                    full_name: $('input[name="full_name"]').val(),
                    mobile_number: $('input[name="mobile_number"]').val(),
                    email: $('input[name="email"]').val(),
                    pincode: $('input[name="pincode"]').val(),
                    landmark: $('input[name="landmark"]').val(),
                    street_address: $('textarea[name="street_address"]').val(),
                    locality: $('select[name="locality"]').val(),
                    city: $('input[name="city"]').val(),
                    state: $('input[name="state"]').val(),
                    country: $('input[name="country"]').val()
                },
                beforeSend: function() {
                    toastFire('info', 'Please wait...');
                },
                success: function(result) {
                    if (result.status == 400) {
                        toastFire('error', result.message);
                    } else {
                        toastFire('success', result.message);
                        window.location = "{{ route('front.address.index') }}";
                        $('#addNewAddress').modal('hide');
                    }
                }
            });
        });
        */

        // set default address
        $(document).on('click', '.address-select', function() {
            let val = $(this).val();
            $.ajax({
                url : '{{route("address.default")}}',
                method : 'POST',
                data : {
                    _token: '{{csrf_token()}}',
                    id: val,
                },
                beforeSend: function() {
                    toastFire('info', 'Please wait...');
                },
                success: function(result) {
                    if (result.status == 400) {
                        toastFire('error', result.message);
                    } else {
                        toastFire('success', result.message);
                    }
                }
            });
        });

        // login mobile number check
        $(document).on('submit', '#loginCheckForm', function(e) {
            e.preventDefault();
            $.ajax({
                url : $(this).attr('action'),
                method : $(this).attr('method'),
                data : {
                    _token: '{{ csrf_token() }}',
                    mobile_number: $('input[name="mobile_no"]').val()
                },
                beforeSend: function() {
                    toastFire('info', 'Please wait...');
                },
                success: function(result) {
                    if (result.status == 400) {
                        toastFire('error', result.message);
                    } else {
                        toastFire('success', result.message);

                        // login
                        if (result.type === "login") {
                            let content = `
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control form-control-sm" id="password" placeholder="**********" name="password" value="" autocomplete="off" required>
                                <label for="password">Password *</label>
                            </div>
                            `;

                            $('#loginResp').html(content);
                            $('#loginCheckForm #password').focus();
                            $('#loginCheckForm #loginMobileNumber').prop('readonly', 'readonly');
                            $('#loginCheckForm').prop('action', "{{route('front.user.check')}}");
                            $('#loginCheckForm').prop('id', "loginCheckUpdated");
                        }
                        // register
                        else {
                            let content = `
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control form-control-sm @error('first_name') is-invalid @enderror" id="first_name" placeholder="First name" name="first_name" value="{{old('first_name')}}" autocomplete="first-name" maxlength="30" autofocus>
                                        <label for="first_name">First name *</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control form-control-sm @error('last_name') is-invalid @enderror" id="last_name" placeholder="Last name" name="last_name" value="{{old('last_name')}}" autocomplete="last-name" maxlength="30">
                                        <label for="last_name">Last name *</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="email" class="form-control form-control-sm @error('email') is-invalid @enderror" id="email" placeholder="Email address" name="email" value="{{old('email')}}" autocomplete="mobile-number" maxlength="50">
                                <label for="email">Email address (optional)</label>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-floating mb-3">
                                <input type="password" class="form-control form-control-sm" id="password" placeholder="**********" name="password" value="" autocomplete="off" required>
                                <label for="password">Password *</label>
                            </div>
                            `;

                            $('#loginResp').html(content);
                            $('#loginCheckForm #first_name').focus();
                            $('#loginCheckForm #loginMobileNumber').prop('readonly', 'readonly');
                            $('#loginCheckForm').prop('action', "{{route('front.user.create')}}");
                            $('#loginCheckForm').prop('id', "loginCheckUpdated");
                        }
                    }
                }
            });
        });

        // in case of new registration. if error occurs
        $(document).ready(function() {
            if($('input[name="mobile_no"]').val().length == 10) {
                $('#loginCheckForm').submit();
            }
        });
    </script>
@endsection