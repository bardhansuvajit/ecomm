@extends('front.layout.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-9">
        <section id="orders">
            <div class="row mb-5">
                <div class="col-12">
                    <div class="page-head">
                        <div class="redirect me-3">
                            {{-- <a href="javascript: void(0)" onclick="history.back(-1)"> --}}
                            <a href="{{ route('front.user.account') }}">
                                <i class="material-icons">keyboard_arrow_left</i>
                            </a>
                        </div>
                        <div class="text">
                            <h5>My orders</h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                @if (!empty($resp['data']))
                    <div class="col-12">
                        @foreach ($resp['data'] as $order)
                            <div class="single-order mb-3">
                                <a href="{{ route('front.user.order.detail', $order->order_no) }}">
                                    <div class="quick-details">
                                        <div class="d-flex justify-content-between">
                                            <div class="start-part">
                                                <h6 class="text-muted">#{{ $order->order_no }}</h6>
                                                <p class="text-muted">
                                                    @php
                                                        $total = 0;
                                                        foreach($order->orderProducts as $product) {
                                                            $total += $product->qty;
                                                        }
                                                    @endphp

                                                    {{ count($order->orderProducts) }} 
                                                    {{ (count($order->orderProducts) > 1) ? 'products' : 'product' }}
                                                    / {{ $total }} 
                                                    {{ ($total > 1) ? 'items' : 'item' }}
                                                </p>
                                            </div>
                                            <div class="end-part">
                                                <p class="text-muted mb-2" title="{{ h_date($order->created_at) }}">Order placed {{ h_date_only($order->created_at) }}</p>
                                                <p class="text-muted">
                                                    Expected delivery in 
                                                    {{ date('j F Y', strtotime($order->created_at.'+'.applicationSettings()->delivery_expect_in_days.' days')) }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="products">
                                        <div class="d-flex">
                                            <div class="order-product">
                                                <img src="http://127.0.0.1:8000/uploads/product-image/6UMKeN3lZ4pgc2rSsFio_medium-thumb_.jpeg" alt="" class="w-100">
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <hr>
                        @endforeach
                    </div>

                    <div class="col-12">
                        {{ $resp['data']->links() }}
                    </div>
                @else
                    <div class="col-12">
                        <div class="empty text-center">
                            <div class="image">
                                <img src="{{ asset('uploads/static-svgs/undraw_product_tour_re_8bai.svg') }}" alt="loading-cart" class="w-100">
                            </div>
                            <h6>No orders found...</h6>
                            <p class="small text-muted">You can check our collections</p>
                            <a href="{{ route('front.collection.index') }}" class="btn btn-sm rounded-0 btn-dark">Go to collections</a>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </div>
</div>
@endsection