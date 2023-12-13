@extends('admin.layout.app')
@section('page-title', 'Coupon detail')

@section('section')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row mb-3">
                            <div class="col-md-12 text-right">
                                <a href="{{ route('admin.coupon.list.all') }}" class="btn btn-sm btn-primary"> <i class="fa fa-chevron-left"></i> Back</a>

                                <a href="{{ route('admin.coupon.edit', $data->id) }}" class="btn btn-sm btn-primary"> <i class="fa fa-edit"></i> Edit</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="small text-muted mb-0">Name</p>
                        <p class="text-dark">{{ $data->name ? $data->name : 'NA' }}</p>

                        <p class="small text-muted mb-0">Code</p>
                        <p class="text-dark">{{ $data->code ? $data->code : 'NA' }}</p>

                        <p class="small text-muted mb-0">Maximum Usage</p>
                        <p class="text-dark">{{ $data->max_no_of_usage ? $data->max_no_of_usage : 'NA' }}</p>

                        <p class="small text-muted mb-0">Maximum Usage per user</p>
                        <p class="text-dark">{{ $data->user_max_no_of_usage ? $data->user_max_no_of_usage : 'NA' }}</p>

                        <p class="small text-muted mb-0">Type</p>
                        <p class="text-dark">{{ ($data->type == 1) ? 'Public' : 'Other' }}</p>

                        <p class="small text-muted mb-0">Start date</p>
                        <p class="text-dark">{{ $data->start_date ? h_date_only($data->start_date) : 'NA' }}</p>

                        <p class="small text-muted mb-0">Expiry date</p>
                        <p class="text-dark">{{ $data->expiry_date ? h_date_only($data->expiry_date) : 'NA' }}</p>

                        <p class="small text-muted mb-0">Discount</p>
                        @if (!empty($data->couponDiscount) && count($data->couponDiscount) > 0)
                            @foreach ($data->couponDiscount as $discount)
                                <h5 class="text-primary font-weight-bold">
                                    {!! $discount->currencyDetails->entity !!} - 
                                    <span>{{ strtoupper($discount->currencyDetails->name) }}</span>
                                    <small class="text-muted">({{ $discount->currencyDetails->full_name }})</small>
                                </h5>
                                @if ($discount->discount_type == 1)
                                    <p class="text-dark font-weight-bold">Flat {{ $discount->discount_amount }} OFF</p>
                                @else
                                    <p class="text-dark font-weight-bold">{{ $discount->discount_amount }}% OFF</p>
                                @endif
                                <hr>
                            @endforeach
                        @endif

                        <p class="small text-muted mb-0">Minimum cart amount</p>
                        @if (!empty($data->minimumCartAmount) && count($data->minimumCartAmount) > 0)
                            @foreach ($data->minimumCartAmount as $cAmount)
                                <h5 class="text-primary font-weight-bold">
                                    {!! $cAmount->currencyDetails->entity !!} - 
                                    <span>{{ strtoupper($cAmount->currencyDetails->name) }}</span>
                                    <small class="text-muted">({{ $cAmount->currencyDetails->full_name }})</small>
                                </h5>

                                <p class="text-dark font-weight-bold">{!! $cAmount->currencyDetails->entity !!} {{ $cAmount->minimum_cart_amount }}</p>
                                <hr>
                            @endforeach
                        @else
                            <p class="text-dark">NA</p>
                        @endif

                        <p class="small text-muted mb-0">Products</p>
                        @if (!empty($data->couponProducts) && count($data->couponProducts) > 0)
                            <table class="table table-sm table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>#ID</th>
                                        <th>Product</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data->couponProducts as $cProduct)
                                        <tr>
                                            <td>{{ $cProduct->product_id }}</td>
                                            <td>
                                                @if (count($cProduct->productDetails->frontImageDetails) > 0)
                                                    <img src="{{ asset($cProduct->productDetails->frontImageDetails[0]->img_small) }}" height="50" class="mr-3">
                                                @else
                                                    <img src="{{ asset('frontend-assets/img/logo.png') }}" height="50" class="mr-3">
                                                @endif

                                                <a href="{{ route('admin.product.detail', $cProduct->productDetails->id) }}">
                                                    {{ $cProduct->productDetails->title }}
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-dark">NA</p>
                        @endif

                        <hr>

                        <p class="small text-muted mb-0">Usage</p>
                        @if (!empty($data->couponUsageTotal) && count($data->couponUsageTotal) > 0)
                            <table class="table table-sm table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>#ID</th>
                                        <th>Order</th>
                                        <th>User</th>
                                        <th>Discount</th>
                                        <th>Final</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data->couponUsageTotal as $order)
                                        <tr>
                                            <td>{{ $order->order_id }}</td>
                                            <td>
                                                <a href="{{ route('admin.order.detail', $order->order_id) }}">
                                                    {{ $order->orderDetails->order_no }}
                                                </a>
                                            </td>
                                            <td>
                                                {{ $order->orderDetails->user_full_name }}
                                            </td>
                                            <td>
                                                {!! $order->orderDetails->orderProducts[0]->currency_entity !!}
                                                {{ $order->orderDetails->coupon_discount }}
                                            </td>
                                            <td>
                                                {!! $order->orderDetails->orderProducts[0]->currency_entity !!}
                                                {{ $order->orderDetails->final_order_amount }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-dark">NA</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

