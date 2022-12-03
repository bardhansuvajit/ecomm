@extends('front.layout.app')

@section('page-title', 'Checkout')

@section('section')
@if(count($data->cart) > 0)
<section class="cart-products mb-3" id="checkout-address">
    <div class="row">

        <div class="col-md-8">
            <div class="payment-header">
                <div class="row">
                    <div class="col-12">
                        <p class="display-6">Payment</p>
                    </div>

                    <div class="col-12">
                        <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('front.cart.index') }}">Cart</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('front.address.index') }}">Address</a></li>
                                <li class="breadcrumb-item active fw-600" aria-current="page">Payment</li>
                            </ol>
                        </nav>
                    </div>

                    {{-- delivery address --}}
                    @if (!empty($data->address))
                    <div class="col-12">
                        {{-- <p class="small text-muted">Delivery address</p> --}}
                        {!! deliveryAddressCard($data->address) !!}
                        <input type="hidden" name="address_id" value="{{$data->address->id}}" form="placeOrder">
                    </div>
                    <div class="col-12 mt-4">
                        <div class="card delivery-details-card">
                            <div class="card-body">
                                <p class="text-dark fw-600 small mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-truck"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>

                                    Free Delivery in {{ env('DELIVERY_IN_DAYS') }}-{{ env('DELIVERY_IN_DAYS')+2 }} days
                                </p>
                                <p class="text-dark fw-600 small mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>

                                    Easy RETURN eligible for {{ env('RETURN_IN_DAYS') }} days
                                </p>
                                <p class="text-dark fw-600 small mb-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-gift"><polyline points="20 12 20 22 4 22 4 12"></polyline><rect x="2" y="7" width="20" height="5"></rect><line x1="12" y1="22" x2="12" y2="7"></line><path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"></path><path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"></path></svg>

                                    No GIFT-WRAP
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- payment method --}}
                    <div class="col-12 mb-3 mt-3">
                        <p class="small text-muted">Payment method</p>
                        <div class="btn-group" role="group">
                            <input type="radio" class="btn-check" name="payment_method" id="online-payment" value="online-payment" autocomplete="off" form="placeOrder">
                            <label class="btn btn-sm btn-outline-primary" for="online-payment">
                                <h5>Online Payment</h5>
                            </label>

                            <input type="radio" class="btn-check" name="payment_method" id="cash-on-delivery" value="cash-on-delivery" autocomplete="off" form="placeOrder" checked>
                            <label class="btn btn-sm btn-outline-primary" for="cash-on-delivery">
                                <h5>Cash on delivery</h5>
                            </label>
                        </div>
                    </div>

                    <div class="col-12 mb-3">
                        @if(env('CASH_ON_DELIVERY_CHARGE') > 0)
                        <p class="small text-muted">Additional &#8377;{{env('CASH_ON_DELIVERY_CHARGE')}} will be charged if cash on delivery is selected</p>
                        @endif

                        <form action="{{ route('front.checkout.order.place') }}" method="POST" id="placeOrder">@csrf
                            {{-- <button type="submit" class="btn btn-primary">Place Order (&#8377;900)</button> --}}
                            <input type="hidden" name="delivery_method" value="free">
                            <button type="submit" class="btn btn-primary address-button">
                                Place Order
                                <span id="totalOrderAmount"></span>
                            </button>
                        </form>
                    </div>
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

                        {{-- @if (!$loop->last) <hr class="my-1"> @endif --}}

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

                    <div class="row">
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
                    </div>
                    <div class="row mt-2">
                        <div class="col-6"><p class="text-muted fw-600 mb-0">Pay ({{$totalQty}} {{$totalQty == 1 ? 'item' : 'items'}})</p></div>
                        <div class="col-6 text-end">
                            <p class="fw-600 mb-0">
                                &#8377;<span id="finalAmountDisplay">{{number_format($finalPayment)}}</span>
                                <span id="finalAmountNotForDisplay" class="d-none">{{$finalPayment}}</span>
                                <input type="hidden" name="finalAmountWTCoupon" value="{{$finalPaymentWithoutCouponDiscount}}">
                            </p>
                        </div>
                    </div>
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
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-info"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                {{-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-up"><polyline points="18 15 12 9 6 15"></polyline></svg> --}}
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
</nav>
@else
<section class="cart-empty">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 mb-4">
                <div class="card-body text-center py-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>

                    <h5 class="display-5 mt-3 mb-4">Your cart is empty</h5>

                    <p class="text-muted">Go &amp; shop some products with us.</p>

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

        // payment method select
        // let paymentMethod = $("input[name='payment_method']:checked").val();
        orderAmount($("input[name='payment_method']:checked").val());

        $("input[name='payment_method']").on('change', function() {
            orderAmount($(this).val());
        });

        function orderAmount(value) {
            let payment = $('#finalAmountNotForDisplay').text();
            if (value == "online-payment") {
                $('#totalOrderAmount').html('(&#8377;'+indianCurrency(payment)+')');
            } else {
                payment = parseInt(payment) + parseInt({{env('CASH_ON_DELIVERY_CHARGE')}});
                $('#totalOrderAmount').html('(&#8377;'+indianCurrency(payment)+')');
            }
        }
    </script>
@endsection