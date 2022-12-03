@extends('front.layout.app')

@section('page-title', 'Cart')

@section('section')
@if(count($data->cart) > 0)
    <section class="cart-products mb-3">
        <div class="row">
            <div class="col-md-8">
                <div class="cart-products">
                    <div class="row">
                        <div class="col-12">
                            <p class="display-6">Cart</p>
                        </div>
                        <div class="col-12">
                            <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item active fw-600" aria-current="page">Cart</li>
                                    <li class="breadcrumb-item"><a href="{{ route('front.address.index') }}">Address</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('front.checkout.index') }}">Payment</a></li>
                                </ol>
                            </nav>
                        </div>

                        {{-- if delivery address is found --}}
                        @auth
                            @if (!empty($data->address))
                            <div class="col-12 mb-3">
                                {!! deliveryAddressCard($data->address) !!}
                            </div>
                            @endif
                        @endauth

                        <div class="col-12">
                            @php
                                $totalCartPrice = $totalQty = $singlePrice = $totalCartDiscount = $couponDiscount = $finalPayment = 0;
                            @endphp

                            @foreach ($data->cart as $cartKey => $cart)
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-2 col-4">
                                                <a href="{{ route('front.product.detail', $cart['slug']) }}" target="_blank">
                                                    <div class="fixed-image-holder" style="height: 70px">
                                                        <img src="{{ asset($cart['image']) }}" alt="">
                                                    </div>
                                                </a>

                                                <div class="quantity">
                                                    <div class="row g-2 align-items-center">
                                                        {{-- <div class="col-auto">
                                                            <label for="quantity__{{$cartKey}}" class="col-form-label">Qty:</label>
                                                        </div> --}}
                                                        <div class="col-auto">
                                                            <form action="{{ route('front.cart.quantity') }}" method="post" class="cart-quantity-form">@csrf
                                                                <select name="qty" id="quantity__{{$cartKey}}" class="form-select form-select-sm quantity-select"  onchange="this.form.submit()">
                                                                    <option value="" selected>Qty: {{$cart['qty']}}</option>
                                                                    @for($i = 1; $i <= 10; $i++ )
                                                                        <option value="{{$i}}">{{$i}}</option>
                                                                    @endfor
                                                                    <option value="10+">10+</option>
                                                                </select>
                                                                @auth
                                                                <input type="hidden" name="id" value="{{$cart['cart_id']}}">
                                                                @endauth
                                                            </form>

                                                            <div class="input-group input-group-sm mb-3 d-none">
                                                                <input type="text" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="quantity_text__{{$cartKey}}">
                                                                <button class="btn btn-secondary" type="button" id="quantity_text__{{$cartKey}}">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-10 col-8">
                                                <a href="{{ route('front.product.detail', $cart['slug']) }}" target="_blank">
                                                    <p class="mb-2 d-inline-block">{{ $cart['title'] }}</p>
                                                </a>
                                                <div class="d-flex">
                                                    @if(!empty($cart['offer_price']))
                                                        {{-- sell price --}}
                                                        <p class="sell-price mb-0">&#8377;{{number_format($cart['offer_price'])}}</p>
                                                        {{-- mrp --}}
                                                        <p class="max-retail-price text-muted mb-0 mx-3">&#8377;{{ number_format($cart['price']) }}</p>
                                                        <p class="discount mb-0">{{ discountCalculate($cart['offer_price'], $cart['price']) }} OFF</p>
                                                    @else
                                                        {{-- sell price --}}
                                                        <p class="sell-price mb-0">&#8377;{{number_format($cart['price'])}}</p>
                                                    @endif
                                                </div>

                                                <p class="mb-0 text-muted">FREE delivery available</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="cart-remove">
                                        @auth
                                            <a href="{{ route('front.cart.remove', $cart['cart_id']) }}" class="small fw-600" onclick="return confirm('Are you sure?')">Remove</a>
                                        @else
                                            <a href="" class="small fw-600" onclick="return confirm('Are you sure?')">Remove</a>
                                        @endauth
                                    </div>
                                </div>

                                @php
                                    $singlePrice += (int) ($cart['offer_price'] == 0.00) ? $cart['price'] : $cart['offer_price'];

                                    // total number of products in cart
                                    $totalQty += (int) $cart['qty'];

                                    // calculate total cart discount
                                    $totalCartDiscount += (int) (($cart['offer_price'] == 0.00) ? 0 : ($cart['price'] - $cart['offer_price'])) * $cart['qty'];

                                    // calculate total cart amount
                                    $totalCartPrice += (int) $cart['price'] * $cart['qty'];

                                    // final payment
                                    $finalPayment += (int) (($cart['offer_price'] == 0) ? $cart['price'] : $cart['offer_price']) * $cart['qty'];

                                    $finalPaymentWithoutCouponDiscount = $finalPayment;
                                @endphp
                            @endforeach

                            @auth
                                @php
                                    // check for coupon, if coupon found
                                    if ($data->cart[0]['coupon_code'] != 0) {
                                        // if FLAT discount
                                        if ($data->cart[0]['coupon_type'] == 2) {
                                            $couponDiscount = $data->cart[0]['coupon_discount'];
                                        }
                                        // if PERCENTAGE discount
                                        else {
                                            $couponDiscount = $finalPayment * ($data->cart[0]['coupon_discount'] / 100);
                                        }
                                    }

                                    $finalPaymentWithoutCouponDiscount = $finalPayment;
                                    $finalPayment = ceil($finalPayment - $couponDiscount);
                                @endphp
                            @endauth
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card" id="checkout_card">
                    <div class="card-body">
                        <h5 class="mb-3">Cart summary ({{$totalQty}})</h5>
                        <div class="row">
                            <div class="col-6"><p class="text-muted">Total</p></div>
                            <div class="col-6 text-end"><p class=""> &#8377;{{number_format($totalCartPrice)}} </p></div>
                        </div>
                        <div class="row">
                            <div class="col-6"><p class="text-muted">Discount</p></div>
                            <div class="col-6 text-end">
                                <p class="">
                                    {{$totalCartDiscount > 0 ? '-' : ''}}
                                    &#8377;{{number_format($totalCartDiscount)}}
                                </p>
                            </div>
                        </div>
                        <div class="row delivery-details">
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
                        </div>

                        <hr>

                        {{-- if coupon applied, show SUBTOTAL --}}
                        @auth
                            <div class="row" id="subTotalRow">
                            @if ($data->cart[0]['coupon_code'] != 0)
                                <div class="col-6"><p class="text-muted">Sub-total</p></div>
                                <div class="col-6 text-end">
                                    <p class="">
                                        &#8377;{{number_format($finalPaymentWithoutCouponDiscount)}}
                                    </p>
                                </div>
                            @endif
                            </div>
                        @endauth

                        <div class="row">
                            <div class="col-12" id="couponStatus">
                                @auth
                                    @if ($data->cart[0]['coupon_code'] == 0)
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
                                                @if ($data->cart[0]['coupon_code'] != 0)
                                                    <div class="col-6 text-end">
                                                        <p class="mb-0 fw-600">
                                                            {!!
                                                                ($data->cart[0]['coupon_type'] == 1) ? $data->cart[0]['coupon_discount'].'% OFF' : '&#8377;'.number_format($data->cart[0]['coupon_discount']).' OFF'
                                                            !!}
                                                        </p>
                                                    </div>
                                                    <div class="col-12">
                                                        <p class="small text-muted mb-0">
                                                            {{$data->cart[0]['coupon_code_name']}}
                                                            <a href="javascript: void(0)" onclick="couponRemove()">Remove?</a>
                                                        </p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                @endauth
                            </div>
                        </div>

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
                        <a href="checkout" class="btn btn-primary address-button w-100">
                            @auth
                                @if (!empty($data->address) > 0)
                                    Payment
                                @else
                                    Address
                                @endif
                            @else
                                Address
                            @endauth
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- cart next page hightlight - only mobile --}}
    <nav class="navbar fixed-bottom redirect_buttons_mobile">
        <div class="row gx-3 mx-0">
            <div class="col-6">
                <a href="javascript: void(0)" class="btn btn-secondary text-start w-100" id="mobile_checkout_info">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-info"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                    &#8377;{{number_format($finalPayment)}}
                </a>
            </div>
            <div class="col-6">
                <a href="{{ route('front.checkout.index') }}" class="btn btn-primary text-end w-100">
                    Address
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </a>
            </div>
        </div>
    </nav>
@else
    <section class="cart-empty">
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card mb-4 border-0 not-found">
                    <div class="card-body text-center py-4">
                        <img src="{{asset('images/static-svgs/undraw_add_to_cart_re_wrdo.svg')}}" alt="" height="100">

                        <h5 class="heading">Cart is empty</h5>

                        <p class="text-muted">Place orders now and get exciting offers.</p>

                        <a href="{{ url('/') }}" class="btn btn-primary">Back to home</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
@endsection

@section('script')
    <script src="{{ asset('./js/coupon-handler.js') }}"></script>

    <script>
        // mobile device checkout information
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
    </script>
@endsection