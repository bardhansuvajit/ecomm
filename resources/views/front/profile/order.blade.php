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
                My orders
            </h5>
        </div>
    </div>

    <div class="row">
        @forelse ($data as $order)
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="text-muted mb-0">
                                    Order number
                                    <span class="text-dark">#{{ $order->order_no }}</span>
                                </p>
            
                                <p class="text-muted mb-0">
                                    Order placed on {{h_date($order->created_at)}}
                                </p>
                            </div>

                            <div class="col-md-6 text-end">
                                <p class="text-muted mb-0">
                                    Order amount
                                    <span class="text-dark"> &#8377;{{ number_format($order->final_order_amount) }}</span>
                                </p>

                                @if ($order->payment_method == 'cod')
                                <p class="text-muted mb-0 fw-600">
                                    Pay &#8377;{{ number_format($order->final_order_amount) }} on time of delivery
                                </p>
                                @else
                                <p class="text-muted mb-0">
                                    
                                </p>
                                @endif
                            </div>
                        </div>

                        <hr>

                        <div class="order-products">
                            <p class="text-muted">
                                Total order quantity {{ $order->total_order_qty }}
                            </p>

                            <ul class="list-group list-group-horizontal mb-3">
                            @foreach ($order->productDetails as $product)
                                <li class="list-group-item border-0 px-3 text-center single-orders">
                                    <div class="image">
                                        <img src="{{ asset($product->product_image) }}" alt="{{ $product->product_slug }}">
                                    </div>

                                    <div class="detail mt-2">
                                        <p class="small text-muted mb-1">Qty: {{ $product->qty }}</p>
                                    </div>
                                </li>
                            @endforeach
                            </ul>

                            <a href="{{ route('front.user.order.detail', $order->id) }}">
                                <h5>View Order details</h5>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 mb-4">
                <div class="card mb-4 border-0 not-found">
                    <div class="card-body text-center py-4">
                        <img src="{{asset('images/static-svgs/undraw_shopping_app_flsj.svg')}}" alt="" height="100">

                        <h5 class="heading">No orders found</h5>

                        <p class="text-muted">Place orders now and get exciting offers.</p>

                        <a href="{{route('front.user.profile')}}" class="btn btn-primary">Back to Profile</a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

</section>
@endsection