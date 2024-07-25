@extends('front.layout.app')

@section('content')
<section id="quick-details">
    <div class="row justify-content-center">

        <div class="col-md-6">
            <div class="row mb-4">
                <div class="col-9">
                    <h5 class="display-6">Thank you, {{ explode(' ', $data->user_full_name)[0] }}</h5>
                    <h5 class="text-muted fw-normal">Order id #{{ $data->order_no }}</h5>
                </div>
                <div class="col-3">
                    <img src="{{ asset('uploads/static-svgs/undraw_order_confirmed_re_g0if.svg') }}" alt="order-placed" class="w-100">
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <h5 class="fw-light">We will soon process your order... Stay tuned.</h5>
                    <p>Free Delivery expected by this {{ date('l F jS, Y', strtotime('+'.$applicationSetting->delivery_expect_in_days.'days')) }}</p>
                </div>
            </div>
        </div>

    </div>
</section>

<div class="row" id="order-details">
    <div class="col-md-4">
        <section id="user-details">
            <h6 class="mb-3">{{ $data->user_full_name }}</h6>

            <p class="mb-0">{{ $data->user_email }}</p>
            <p>{{ $data->user_phone_no }}</p>

            <p class="text-muted">You were logged in with this account while placing this order. You can find order details in, {{ $data->user_email }}</p>
        </section>
    </div>

    @if ($data->addressDetails)
    <div class="col-md-4">
        <section id="address-details">
            <div class="delivery-address">
                <p class="text-dark mb-2">Delivery Address</p>
                <p class="small text-muted mb-0">
                    {{ $data->addressDetails->shipping_address_user_full_name }}, 
                    {{ $data->addressDetails->shipping_address_user_phone_no1 }}
                </p>
                <p class="small text-muted">
                    {{ $data->addressDetails->shipping_address_street_address }},
                    {{ $data->addressDetails->shipping_address_city ? $data->addressDetails->shipping_address_city.', ' : '' }}
                    {{ $data->addressDetails->shipping_address_postcode }},
                    {{ $data->addressDetails->shipping_address_state }}
                </p>
            </div>

            <div class="billing-address">
                <p class="text-dark mb-2">Billing Address</p>
                <p class="small text-muted mb-0">
                    {{ $data->addressDetails->billing_address_user_full_name }}, 
                    {{ $data->addressDetails->billing_address_user_phone_no1 }}
                </p>
                <p class="small text-muted">
                    {{ $data->addressDetails->billing_address_street_address }},
                    {{ $data->addressDetails->billing_address_city ? $data->addressDetails->billing_address_city.', ' : '' }}
                    {{ $data->addressDetails->billing_address_postcode }},
                    {{ $data->addressDetails->billing_address_state }}
                </p>
            </div>
        </section>
    </div>
    @endif

    <div class="col-md-4">
        <section id="payment-details">
            <p class="text-dark mb-2">Payment details</p>
            <table class="table table-sm mb-0">
                <tbody>
                    <tr>
                        <td>
                            <p class="small text-muted mb-0">Cart</p>
                        </td>
                        <td class="text-end currency">
                            <p class="small text-muted mb-0">
                                <span class="currency-icon">Rs</span>
                                <span class="amount">{{ $data->total_cart_amount }}</span>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p class="small text-muted mb-0">Shipping</p>
                        </td>
                        <td class="text-end currency">
                            <p class="small text-muted mb-0">
                                <span class="currency-icon">Rs</span>
                                <span class="amount">{{ $data->shipping_charge }}</span>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p class="small text-muted mb-0">TAX</p>
                        </td>
                        <td class="text-end currency">
                            <p class="small text-muted mb-0">
                                <span class="currency-icon">Rs</span>
                                <span class="amount">{{ $data->tax_in_amount }}</span>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p class="small text-muted mb-0">Discount</p>
                        </td>
                        <td class="text-end currency">
                            <p class="small text-muted mb-0">
                                <span class="currency-icon">Rs</span>
                                <span class="amount">{{ $data->coupon_discount }}</span>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td class="border-0">
                            <p class="small text-muted fw-bold mb-0">Total</p>
                        </td>
                        <td class="text-end currency border-0">
                            <p class="small text-muted fw-bold mb-0">
                                <span class="currency-icon">Rs</span>
                                <span class="amount">{{ $data->final_order_amount }}</span>
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </section>
    </div>
</div>

@if ($data->orderProducts)
<section id="order-products">
    <div class="d-flex">
        @foreach ($data->orderProducts as $product)
            <div class="single-order-product">
                <a href="{{ route('front.product.detail', $product->product_slug) }}" target="_blank">
                    <div class="image-section">
                        <div class="image-holder">
                            <img src="{{ asset($product->product_image) }}" alt="" class="w-100">
                        </div>
                    </div>
                    <div class="content-section">
                        <p class="height-2 text-dark mb-2">{{ $product->product_title }}</p>
                        <p class="height-2 text-dark fw-bold mb-2">{{ $product->variation_info }}</p>

                        <p class="text-dark">
                            <span class="">Qty: </span>
                            <span class="fw-bold">{{ $product->qty }}</span>
                        </p>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    <div class="row mt-4">
        <div class="col-md-12 text-center">
            <a href="{{ route('front.user.order.index') }}" class="btn btn-sm btn-dark rounded-0">View all orders</a>
        </div>
    </div>
</section>
@endif
@endsection