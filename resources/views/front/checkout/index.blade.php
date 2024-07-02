@extends('front.layout.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-head">
            <div class="redirect me-3">
                <a href="javascript: void(0)" onclick="history.back(-1)">
                    <i class="material-icons">keyboard_arrow_left</i>
                </a>
            </div>
            <div class="text">
                <h5>Checkout</h5>
            </div>
        </div>
    </div>

    @guest
        @php
            $acc1_headerClass = "";
            $acc1_bodyClass = "show";

            $acc2_headerClass = "collapsed";
            $acc2_bodyClass = "";

            $acc3_headerClass = "collapsed";
            $acc3_bodyClass = "";
        @endphp
    @else
        @php
            if (empty(auth()->guard('web')->user()->first_name) || 
            empty(auth()->guard('web')->user()->last_name) || 
            empty(auth()->guard('web')->user()->email)) {
                $acc1_headerClass = "";
                $acc1_bodyClass = "show";

                $acc2_headerClass = "collapsed";
                $acc2_bodyClass = "";

                $acc3_headerClass = "collapsed";
                $acc3_bodyClass = "";
            } else {
                $acc1_headerClass = "collapsed";
                $acc1_bodyClass = "";

                $acc2_headerClass = "";
                $acc2_bodyClass = "show";

                $acc3_headerClass = "collapsed";
                $acc3_bodyClass = "";
            }
        @endphp
    @endguest

    <div class="col-md-8">
        <div id="checkout-page">

            <div class="accordion accordion-flush" id="checkoutAccordion">
                <section id="account" class="p-0">
                    <div class="accordion-item">
                        <div class="accordion-header">
                            <button class="accordion-button {{$acc1_headerClass}}" type="button" 
                            data-bs-toggle="collapse" 
                            aria-expanded="true" aria-controls="collapseAccount">
                                <div class="section-heading">
                                    <div class="d-flex">
                                        <div class="number bg-dark text-light">
                                            <h5 class="">1</h5>
                                        </div>
                                        <div class="ms-3">
                                            <h6 class="mb-0 fw-bold">Account</h6>
                                            @guest
                                                <p class="small text-muted mb-0">Login to complete Checkout</p>
                                            @else
                                                @if (auth()->guard('web')->user()->first_name)
                                                    <p class="small text-muted mb-0">{{ auth()->guard('web')->user()->first_name }}, {{ auth()->guard('web')->user()->mobile_no }}</p>
                                                @else
                                                    <p class="small text-muted mb-0">Profile for {{ auth()->guard('web')->user()->mobile_no }}</p>
                                                @endif
                                            @endguest
                                        </div>
                                    </div>
                                </div>
                            </button>
                        </div>
                        <div id="collapseAccount" class="accordion-collapse collapse {{$acc1_bodyClass}}" data-bs-parent="#checkoutAccordion">
                            <div class="accordion-body">
                                @guest
                                    <div id="account-notloggedin">
                                        <form action="{{ (count($mobileCheck) > 0) ? route('front.checkout.login.check') : '' }}" method="{{ (count($mobileCheck) > 0) ? 'post' : 'get' }}">@csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mobile-number-holder mb-3">
                                                        <label for="mobile_no"><h6 class="mb-1">Mobile number</h6></label>

                                                        <input type="number" class="form-control" name="mobile_no" id="mobile_no" placeholder="Enter mobile number" onkeypress="return isNumeric(event)" oninput="maxLengthCheck(this)" maxlength="10" value="{{ request()->input('mobile_no') }}" {{ (count($mobileCheck) == 0) ? 'autofocus' : '' }} required>

                                                        <p>Enter mobile number without country code</p>

                                                        @error('mobile_no') <p class="text-danger">{{ $message }}</p> @enderror
                                                    </div>
                                                </div>

                                                @if (count($mobileCheck) > 0)
                                                <div class="col-md-6">
                                                    <div class="password-holder mb-3">
                                                        <label for="password"><h6 class="mb-1">Password</h6></label>

                                                        <div class="input-group">
                                                            <input type="password" class="form-control" name="password" id="password" placeholder="Password" oninput="maxLengthCheck(this)" maxlength="30" {{ (count($mobileCheck) > 0) ? 'autofocus' : '' }}>

                                                            <span class="input-group-text">
                                                                <button type="button" class="visibility-toggle">
                                                                    <i class="material-icons">visibility_off</i>
                                                                </button>
                                                            </span>
                                                        </div>

                                                        <p class="{{ ($mobileCheck['type'] == "login-blocked") ? "text-danger" : "text-success" }}">{{ $mobileCheck['message'] }}</p>

                                                        @error('password') <p class="text-danger">{{ $message }}</p> @enderror
                                                    </div>
                                                </div>

                                                <input type="hidden" name="type" value="{{ $mobileCheck['type'] }}">
                                                @endif

                                                <div class="col-12">
                                                    <div class="redirect-buttons">
                                                        <div class="d-flex">
                                                            <button type="submit" class="btn btn-sm btn-dark rounded-0">Submit</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                @else
                                    <div id="account-loggedin">
                                        @if (empty(auth()->guard('web')->user()->first_name) || 
                                        empty(auth()->guard('web')->user()->last_name) || 
                                        empty(auth()->guard('web')->user()->email))
                                            <form action="{{ route('front.checkout.user.detail') }}" method="post">@csrf
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <p class="mb-2 text-muted">Tell us more about yourself</p>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="first-name-holder mb-3">
                                                            <label for="first_name"><h6 class="mb-1">First name <span class="text-muted">*</span></h6></label>

                                                            <input type="text" class="form-control" name="first_name" id="first_name" placeholder="Enter first name" maxlength="50" value="{{ old('first_name') ? old('first_name') : auth()->guard('web')->user()->first_name }}" autofocus required>

                                                            @error('first_name') <p class="text-danger">{{ $message }}</p> @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="last-name-holder mb-3">
                                                            <label for="last_name"><h6 class="mb-1">Last name <span class="text-muted">*</span></h6></label>

                                                            <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Enter last name" maxlength="50" value="{{ old('last_name') ? old('last_name') : auth()->guard('web')->user()->last_name }}" required>

                                                            @error('last_name') <p class="text-danger">{{ $message }}</p> @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="email-address-holder mb-3">
                                                            <label for="email"><h6 class="mb-1">Email address <span class="text-muted">*</span></h6></label>

                                                            <input type="email" class="form-control" name="email" id="email" placeholder="Enter email address" oninput="maxLengthCheck(this)" maxlength="130" value="{{ old('email') ? old('email') : auth()->guard('web')->user()->email }}" required>

                                                            @error('email') <p class="text-danger">{{ $message }}</p> @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="redirect-buttons">
                                                            <div class="d-flex">
                                                                <button type="submit" class="btn btn-sm btn-dark rounded-0">Submit</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        @else
                                            <h6>
                                                {{auth()->guard('web')->user()->first_name}} {{auth()->guard('web')->user()->last_name}}, 
                                                {{auth()->guard('web')->user()->mobile_no}}
                                            </h6>

                                            <p class="small text-muted">
                                                Logged in as 
                                                <strong>{{auth()->guard('web')->user()->first_name}} {{auth()->guard('web')->user()->last_name}}</strong>. 

                                                <a href="javascript: void(0)" title="You will be logged out." onclick="document.getElementById('logout-form').submit()">Not {{auth()->guard('web')->user()->first_name}}/ Login with a different account ?</a>
                                            </p>

                                            <div class="redirect-buttons">
                                                <div class="d-flex">
                                                    <a data-bs-toggle="collapse" href="#collapseAddress" aria-controls="collapseAddress" class="btn btn-sm btn-dark rounded-0">Delivery address</a>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endguest
                            </div>
                        </div>
                    </div>
                </section>

                <section id="address" class="p-0">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button {{$acc2_headerClass}}" type="button" 
                            data-bs-toggle="collapse" 
                            aria-expanded="false" aria-controls="collapseAddress">
                                <div class="section-heading">
                                    <div class="d-flex">
                                        <div class="number bg-dark text-light">
                                            <h5 class="">2</h5>
                                        </div>
                                        <div class="ms-3">
                                            <h6 class="mb-0 fw-bold">Address</h6>

                                            @guest
                                                <p class="small text-muted mb-0">Login to find saved Delivery address</p>
                                            @else
                                                @if (!empty($data->deliveryAddresses['status']) && $data->deliveryAddresses['status'] == 'success')
                                                    <p class="small text-muted mb-0" id="address-head-detail">
                                                        {{ $data->deliveryAddresses['data'][0]->street_address }},
                                                        {{ $data->deliveryAddresses['data'][0]->zipcode }},
                                                        {{ $data->deliveryAddresses['data'][0]->state }}
                                                    </p>
                                                @else
                                                    <p class="small text-muted mb-0">Enter your delivery address</p>
                                                @endif
                                            @endguest
                                        </div>
                                    </div>
                                </div>
                            </button>
                        </h2>
                        <div id="collapseAddress" class="accordion-collapse collapse {{$acc2_bodyClass}}" data-bs-parent="#checkoutAccordion">
                            <div class="accordion-body">
                                @auth
                                    @if (!empty($data->deliveryAddresses['status']) && $data->deliveryAddresses['status'] == 'success')
                                        <div id="address-exists">
                                            @if (count($data->deliveryAddresses['data']) == 1)
                                                <p>Delivery address</p>
                                            @else
                                                <p>Select delivery address</p>
                                            @endif

                                            <div class="address-list">
                                                @foreach ($data->deliveryAddresses['data'] as $addressIndex => $address)
                                                    <div class="single-address">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="delivery-address" id="address{{$addressIndex}}" value="{{ $address->id }}" {{ ($addressIndex == 0) ? 'checked' : '' }} data-detail="{{ $address->street_address }}, {{ $address->zipcode }}, {{ $address->state }}">
                                                            <label class="form-check-label" for="address{{$addressIndex}}">
                                                                <h6 class="mb-0">
                                                                    {{ $address->full_name }} 
                                                                    <strong>{{ $address->contact_no1 }}</strong>
                                                                </h6>
                                                                <p class="text-muted">
                                                                    {{ $address->street_address }},
                                                                    {{ $address->city }}
                                                                    {{ $address->zipcode }},
                                                                    {{ $address->state }}
                                                                </p>
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>


                                            <div id="change-delivery-address" style="{!! (request()->input('billing-address-error') == "true") ? 'display: none' : 'display: block' !!}">
                                                <p><a data-bs-toggle="collapse" href="#addDeliveryAddress" aria-expanded="false" aria-controls="addDeliveryAddress">Change Delivery address</a></p>
                                            </div>

                                            <div id="billing-address" style="{!! (request()->input('delivery-address-error') == "true") ? 'display: none' : 'display: block' !!}">
                                            @if (!empty($data->billingAddresses['status']) && $data->billingAddresses['status'] == 'success')
                                                <p>Billing address</p>

                                                <div class="billing-address-list">
                                                    @foreach ($data->billingAddresses['data'] as $b_addressIndex => $b_address)
                                                        <div class="single-address">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="billing-address" id="billing-address{{$b_addressIndex}}" value="{{ $b_address->id }}" {{ ($b_addressIndex == 0) ? 'checked' : '' }}>

                                                                <label class="form-check-label" for="billing-address{{$b_addressIndex}}">
                                                                    <h6 class="mb-0">
                                                                        {{ $b_address->full_name }} 
                                                                        <strong>{{ $b_address->contact_no1 }}</strong>
                                                                    </h6>
                                                                    <p class="text-muted">
                                                                        {{ $b_address->street_address }},
                                                                        {{ $b_address->city }}
                                                                        {{ $b_address->zipcode }},
                                                                        {{ $b_address->state }}
                                                                    </p>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>

                                                <div id="change-billing-address" style="{!! (request()->input('delivery-address-error') == "true") ? 'display: none' : 'display: block' !!}">
                                                    <p>
                                                        <a href="{{ route('front.checkout.billing.address.remove.all') }}">Make Billing address same as Delivery address</a>
                                                        {{-- <a href="javascript: void(0)" onclick="makeBillingSameAsDeliveryAddr()">Make Billing address same as Delivery address</a> --}}

                                                        <span class="mx-2">|</span>

                                                        <a data-bs-toggle="collapse" href="#addBillingAddress" aria-expanded="false" aria-controls="addBillingAddress" title="Current Billing address will be removed">Change Billing address</a>
                                                    </p>
                                                </div>

                                                <div id="delivery-billing-address">
                                                    <p>Delivery address &amp; Billing address are different. </p>
                                                </div>
                                            @else
                                                <div id="change-billing-address">
                                                    <p>Delivery address is same as Billing address. <a data-bs-toggle="collapse" href="#addBillingAddress" aria-expanded="false" aria-controls="addBillingAddress">Want to add a different Billing address ?</a></p>
                                                </div>
                                            @endif
                                            </div>

                                            <div id="new-delivery-address">
                                                <div class="collapse {{ (request()->input('delivery-address-error') == "true") ? 'show' : '' }}" id="addDeliveryAddress">
                                                    @include('front.quick.delivery-address-add')
                                                </div>
                                            </div>

                                            <div id="new-billing-address">
                                                <div class="collapse {{ (request()->input('billing-address-error') == "true") ? 'show' : '' }}" id="addBillingAddress">
                                                    @include('front.quick.billing-address-add')
                                                </div>
                                            </div>

                                            <div class="address-redirect-buttons" id="confirmedAddress" style="{!! (request()->input('delivery-address-error') == "true") ? 'display: none;' : 'display: block;' !!}{!! (request()->input('billing-address-error') == "true") ? 'display: none' : 'display: block' !!}">
                                                <p>Free Delivery expected by this {{ date('l F jS, Y', strtotime('+'.$applicationSetting->delivery_expect_in_days.'days')) }}</p>

                                                <div class="redirect-buttons">
                                                    <div class="d-flex">
                                                        <a data-bs-toggle="collapse" href="#collapseAccount" aria-controls="collapseAccount" class="btn btn-sm btn-light rounded-0">Account</a>

                                                        <a data-bs-toggle="collapse" href="#collapsePayment" aria-controls="collapsePayment" class="btn btn-sm btn-dark rounded-0">Payment</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div id="addDeliveryAddress" class="remove-cancel show-account">
                                            @include('front.quick.delivery-address-add')
                                        </div>
                                        <div id="addBillingAddress"></div>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                </section>

                <section id="payment" class="p-0">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button {{$acc3_headerClass}}" type="button" 
                            {{-- data-bs-toggle="collapse" --}}
                            aria-expanded="false" aria-controls="collapsePayment">
                                <div class="section-heading">
                                    <div class="d-flex">
                                        <div class="number bg-dark text-light">
                                            <h5 class="">3</h5>
                                        </div>
                                        <div class="ms-3">
                                            <h6 class="mb-0 fw-bold">Payment</h6>
                                            <p class="small text-muted mb-0">Select payment method</p>
                                        </div>
                                    </div>
                                </div>
                            </button>
                        </h2>
                        <div id="collapsePayment" class="accordion-collapse collapse {{$acc3_bodyClass}}" data-bs-parent="#checkoutAccordion">
                            <div class="accordion-body">
                                @auth
                                <form action="{{ route('front.checkout.store') }}" method="post">@csrf
                                    <div class="payment-gateway-container">
                                        <div id="available-gateways">
                                            @foreach ($data->payment_methods as $payment_method)
                                            <div class="single-gateway mb-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="payment_method" id="method-{{$payment_method->id}}" {{ ($payment_method->checked == 1) ? 'checked' : '' }} value="{{$payment_method->value}}">

                                                    <label class="form-check-label" for="method-{{$payment_method->id}}">
                                                        @if ($payment_method->name == "Cash on delivery")
                                                            <h6>{{$payment_method->name}}</h6>
                                                        @else
                                                            <img src="{{ asset($payment_method->image) }}" alt="{{$payment_method->value}}" style="height: 20px;">
                                                        @endif

                                                        @if ($payment_method->details)
                                                            <p>{{$payment_method->details}}</p>
                                                        @endif
                                                    </label>
                                                </div>
                                            </div>
                                            @endforeach

                                            <div id="order-place-button">
                                                <input type="hidden" name="razorpay_payment_id">
                                                <input type="hidden" name="delivery_method" value="free">

                                                @if (!empty($data->billingAddresses['status']) && $data->billingAddresses['status'] == 'success')
                                                    <input type="hidden" name="billing_same_as_shipping" value="false">
                                                @else
                                                    <input type="hidden" name="billing_same_as_shipping" value="true">
                                                @endif

                                                <a data-bs-toggle="collapse" href="#collapseAddress" aria-controls="collapseAddress" class="btn btn-sm btn-light rounded-0">Address</a>

                                                @foreach ($data->payment_methods as $payment_method)
                                                    @if($payment_method->value == "cash-on-delivery")
                                                        <button class="payment-btns payment-btn-{{$payment_method->value}} btn btn-sm btn-dark rounded-0 {{ ($payment_method->checked == 1) ? '' : 'd-none' }} ">Place order</button>
                                                    @endif

                                                    @if($payment_method->value == "razorpay")
                                                        <button class="payment-btns payment-btn-{{$payment_method->value}} btn btn-sm btn-dark rounded-0 {{ ($payment_method->checked == 1) ? '' : 'd-none' }}" id="rzp-button1">Pay now</button>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                @endauth
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <div class="col-md-4" id="quickCart">
        <section id="checkout-cart-data">
            <div id="cart-heading">
                <h5>CART</h5>
            </div>
            <div id="cart-status">
                <div class="cart-exists">

                    @include('front.quick.cart-product')

                </div>
            </div>
        </section>
    </div>
</div>

<div id="onscroll-nav"></div>
@endsection

@section('script')
    <script>
        quickCartListUpdate();

        $('input[name="payment_method"]').on('click', function() {
            let val = $(this).val();
            $('.payment-btns').addClass('d-none');
            $('.payment-btn-'+val).removeClass('d-none');
        })
    </script>

    @foreach ($data->payment_methods as $payment_method)
        @if($payment_method->value == "razorpay")
            @php
                if ($payment_method->stage == 1) {
                    $key1 = $payment_method->live_key1;
                } else {
                    $key1 = $payment_method->test_key1;
                }
            @endphp

            <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

            <script>
            $(window).on('load', function() {
                let finalAmount = $('#payable').text()*100;

                var options = {
                    "key": "{{$key1}}",
                    "amount": finalAmount,
                    "currency": "INR",
                    "name": "{{$payment_method->company_name_display}}",
                    "description": "{{$payment_method->description}}",
                    "image": "{{asset($payment_method->image_square)}}",
                    // "order_id": "order_IluGWxBm9U8zJ8", //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
                    "handler": function (response){
                        // console.log('razorpay_payment_id>> '+response.razorpay_payment_id);
                        // console.log('razorpay_order_id>> '+response.razorpay_order_id);
                        // console.log('razorpay_signature>> '+response.razorpay_signature)

                        // console.log(response);
                        $('input[name="razorpay_payment_id"]').val(response.razorpay_payment_id);
                        $('.checkout-form').submit();
                    },
                    "prefill": {
                        "name": "Gaurav Kumar",
                        "email": "gaurav.kumar@example.com",
                        "contact": "9000090000"
                    },
                    "theme": {
                        "color": "{{$payment_method->theme_color}}"
                    }
                };
                var rzp1 = new Razorpay(options);
                rzp1.on('payment.failed', function (response){
                    alert(response.error.code);
                    alert(response.error.description);
                    alert(response.error.source);
                    alert(response.error.step);
                    alert(response.error.reason);
                    alert(response.error.metadata.order_id);
                    alert(response.error.metadata.payment_id);
                });

                document.getElementById('rzp-button1').onclick = function(e){
                    if ($('input[name="payment_method"]:checked').val() == "razorpay") {
                        rzp1.open();
                        e.preventDefault();
                    }
                }
            });
            </script>
        @endif
    @endforeach
@endsection
