@extends('front.layout.app')

@section('page-title', 'order detail')

@section('section')
<section id="orderDetail">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <div class="icon text-success">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg>
            </div>

            <div class="order-text">
                <h5 class="display-6">Order Placed</h5>
                <p class="text-muted">We are processing your order</p>
            </div>
        </div>
    </div>

    @php
        $delivery_in = env('DELIVERY_IN_DAYS');
        $expdt_delivery = date('l j F, Y', strtotime($data->created_at.' +'.$delivery_in.' days'));

        $payment_method = ($data->payment_method == "cod") ? "Unpaid (Cash on delivery)" : "Paid already";
    @endphp

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <p class="small text-muted">Order information</p>
                    <p class="text-muted mb-2">Order number <span class="text-dark">#{{$data->order_no}}</span></p>
                    <p class="text-muted mb-2">Order placed on <span class="text-dark">{{h_date($data->created_at)}}</span></p>
                    <p class="text-muted mb-2">Expect delivery this <span class="text-dark">{{ $expdt_delivery }}</span></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <p class="small text-muted">Delivery address</p>
                    <p class="text-dark mb-0">{{$data->addressDetails->full_name}}, {{$data->addressDetails->mobile_no}}</p>
                    <p class="small text-muted mb-2">{{$data->addressDetails->email}}</p>
                    <p class="small text-muted mb-0">
                        {{$data->addressDetails->street_address}},
                        {{$data->addressDetails->city}},
                        {{$data->addressDetails->pincode}},
                        {{$data->addressDetails->locality}},
                        {{$data->addressDetails->state}}
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <p class="small text-muted">Other information</p>
                    <p class="text-muted mb-2">Delivery method <span class="text-dark">{{strtoupper($data->delivery_method)}}</span></p>
                    <p class="text-muted mb-2">Payment method <span class="text-dark">{{$payment_method}}</span></p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                        @php
                            $totalCartPrice = $totalQty = $singlePrice = $totalCartDiscount = $couponDiscount = $finalPayment = 0;
                        @endphp

                        @foreach ($data->productDetails as $product)
                        <div class="card card-body border-0">
                            <div class="row">
                                <div class="col-md-2 col-4">
                                    <a href="{{ route('front.product.detail', $product->productDetails->slug) }}" target="_blank">
                                        <div class="fixed-image-holder" style="height: 50px">
                                            <img src="{{ asset($product->productDetails->imageDetails[0]->img_50) }}" alt="">
                                        </div>
                                    </a>
                                </div>

                                <div class="col-md-10 col-8">
                                    <p class="mb-0 d-inline-block">{{ $product->productDetails->title }}</p>
                                    <div class="d-flex">
                                        <p class="small text-muted me-3 mb-0">Qty: <span class="fw-600 text-dark">{{$product->qty}}</span></p>
                                        @if(!empty($product->productDetails->offer_price))
                                            <p class="small sell-price mb-0">&#8377;{{number_format($product->productDetails->offer_price)}}</p>
                                        @else
                                            <p class="small sell-price mb-0">&#8377;{{number_format($product->productDetails->price)}}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        @if(!$loop->last) <hr class="my-1"> @endif

                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <p class="small text-muted">Order summary ({{ $data->total_order_qty }})</p>

                    <p class="text-muted mb-2">Total <span class="text-dark">&#8377;{{number_format($data->cart_total_order_amount)}}</span></p>
                    <p class="text-muted mb-2">Discount <span class="text-dark">&#8377;{{number_format($data->cart_product_discount)}}</span></p>
                    <p class="text-muted mb-2">Delivery charge <span class="text-dark">&#8377;{{number_format($data->delivery_charges)}}</span></p>
                    <p class="text-muted mb-2">Payment method charge <span class="text-dark">&#8377;{{number_format($data->payment_method_charge)}}</span></p>
                    <p class="text-muted mb-2">Final <span class="text-dark">&#8377;{{number_format($data->final_order_amount)}}</span></p>
                </div>
            </div>
        </div>
    </div>

    <div class="row my-4">
        <div class="col-12 text-center">
            <a href="{{ route('front.user.order') }}" class="btn btn-secondary">
                Back to orders
            </a>
        </div>
    </div>
</section>



{{-- <section id="userOrders">
    <div class="row">
        <div class="col-12">
            <h5 class="display-6 mb-4">
                <a href="{{ route('front.user.profile') }}" class="back-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg>
                </a>
                My orders
            </h5>
        </div>
    </div>

    <div class="row">
        <div class="col-12 orders">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <div class="left">
                            <p class="small mb-1">Order no: TZO094589</p>
                            <p class="small mb-0 text-muted">Order placed on 12 January, 2022</p>
                        </div>
                        <div class="right text-end">
                            <a href="" class="btn btn-sm btn-primary mt-2">
                                <span class="d-none d-md-block">View order details</span>
                                <span class="d-block d-md-none">Details</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="row">
                                <div class="col-md-1 col-4">
                                    <a href="#" target="_blank">
                                        <div class="fixed-image-holder" style="height: 70px">
                                            <img src="http://127.0.0.1:8000/uploads/product/se45te65er6sdsr6e55r76br6775_1056.jpeg" alt="">
                                        </div>
                                    </a>
                                </div>

                                <div class="col-md-11 col-8">
                                    <a href="#" target="_blank">
                                        <p class="mb-0 d-inline-block">Lorem ipsum dolor sit amet</p>
                                    </a>
                                    <p class="small mb-0 text-muted">Qty: 11</p>
                                    <p class="fw-600 sell-price mb-0">&#8377;1,999</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 text-end">
                            <div class="d-flex d-md-block justify-content-between">
                                <div class="order-status mt-2">
                                    <p>We are processing your order</p>
                                </div>
                                <a href="" class="small">
                                    <span class="d-none d-md-block mt-2">Talk to support about this order</span>
                                    <span class="d-block d-md-none mt-2">Support</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> --}}
@endsection