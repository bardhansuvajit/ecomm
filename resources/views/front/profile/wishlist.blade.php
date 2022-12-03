@extends('front.layout.app')

@section('page-title', 'order')

@section('section')
<section id="userOrders">
    <div class="row">
        <div class="col-12">
            <h5 class="display-6 mb-4">
                <a href="{{ route('front.user.profile') }}" class="back-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg>
                </a>
                My wishlist
            </h5>
        </div>
    </div>

    {{-- use order products loop, as multiple products from single order must be in different orders --}}
    <div class="row">
        <div class="col-12 orders">
            <div class="card">
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
                                    <div class="d-flex">
                                        {{-- @if(!empty($cart->productDetails->offer_price)) --}}
                                            <p class="sell-price mb-0">
                                                &#8377;499
                                                {{-- &#8377;{{number_format($cart->productDetails->offer_price)}} --}}
                                            </p>
                                            <p class="max-retail-price text-muted mb-0 mx-3">
                                                &#8377;1,999
                                                {{-- &#8377;{{ number_format($cart->productDetails->price) }} --}}
                                            </p>
                                            <p class="discount mb-0">
                                                22% OFF
                                                {{-- {{ discountCalculate($cart->productDetails->offer_price, $cart->productDetails->price) }} OFF --}}
                                            </p>
                                        {{-- @else
                                            <p class="sell-price mb-0">&#8377;{{number_format($cart->productDetails->price)}}</p>
                                        @endif --}}
                                    </div>

                                    <p class="mb-0 text-muted">FREE delivery available</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 text-end">
                            <a href="" class="btn btn-sm btn-secondary" onclick="return confirm('Are you sure?')">Remove</a>
                            <a href="" class="btn btn-sm btn-primary">Add to Cart</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



{{-- @if(count($data) > 0)
<section class="product-detail mb-3">
    <div class="row mx-0">
        <div class="col-md-6">
            @php
                $totalPrice = $totalQty = 0;
            @endphp

            @foreach ($data as $order)
            <div class="card card-body mb-3">
                <div class="row">
                    <div class="col-12">
                        <p>Order : {{$order->order_no}}</p>
                    </div>

                    @foreach ($order->orderProducts as $product)
                        <div class="row mx-0">
                            <div class="col-4">
                                <div class="fixed-image-holder" style="height: 50px">
                                    <img src="{{ asset($product->productDetails->imageDetails[0]->img_50) }}" alt="">
                                </div>
                            </div>
        
                            <div class="col-8">
                                <p class="mb-2">{{ $product->productDetails->title }}</p>
                                <p class="mb-0">&#8377; {{ number_format($product->productDetails->price) }} &times; {{ $product->qty }}</p>
                            </div>
                            <hr>
                        </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@else
<section style="background-color: #eee;">
    <div class="container pt-3 pb-5">
        <div class="row mx-0">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-body text-center py-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>

                        <h5 class="display-5 mt-3 mb-4">No orders found</h5>

                        <p class="text-muted">Go &amp; shop some products with us.</p>

                        <a href="{{ url('/') }}" class="btn btn-primary">Back to home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif --}}
@endsection