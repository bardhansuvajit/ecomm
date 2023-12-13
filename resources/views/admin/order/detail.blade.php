@extends('admin.layout.app')
@section('page-title', 'Order detail')

@section('section')

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row mb-3">
                            <div class="col-md-12 text-right">
                                <a href="{{ route('admin.order.list.all') }}" class="btn btn-sm btn-primary"> <i class="fa fa-chevron-left"></i> Back</a>

                                {{-- <a href="{{ route('admin.order.edit', $data->id) }}" class="btn btn-sm btn-primary"> <i class="fa fa-edit"></i> Edit</a> --}}
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="font-weight-bold text-primary">Order</h5>

                        <p class="small text-muted mb-0">Order no</p>
                        <p class="text-dark">{{ $data->order_no ? $data->order_no : 'NA' }}</p>

                        <p class="small text-muted mb-0">Order placed</p>
                        <p class="text-dark" title="{{ $data->created_at }}">{{ $data->created_at ? h_date($data->created_at) : 'NA' }}</p>

                        <hr>

                        <h5 class="font-weight-bold text-primary">Product</h5>

                        <div class="row mb-3">
                            <div class="col-md-2">
                                <p class="small text-muted mb-0">Quick update all products status</p>
                                <select name="status" id="status" class="form-control form-control-sm" data-route="{{ route('admin.order.status', $data->id) }}">
                                    <option value="">Select...</option>
                                    @foreach ($productStatus as $status)
                                        <option value="{{ $status->value }}">{{ $status->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row product-container-detail">
                            @foreach ($data->orderProducts as $product)
                                <div class="col-md-2 single-product text-center">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="img-holder">
                                                @if (!empty($product->product_image) && file_exists(public_path($product->product_image)))
                                                    <img src="{{ asset($product->product_image) }}" alt="image">
                                                @else
                                                    <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" alt="image">
                                                @endif
                                                {{-- <img src="{{ asset($product->product_image) }}" alt="image"> --}}
                                            </div>
                                            <div class="details">
                                                <a href="{{ route('admin.product.detail', $product->product_id) }}" class="small mb-1">{{ $product->product_title }}</a>
                                                <div class="d-flex justify-content-center">
                                                    <p class="text-dark mb-2">
                                                        <span class="small text-muted">Qty: </span>
                                                        <span class="font-weight-bold text-primary">{{ $product->qty }}</span>
                                                    </p>
                                                    <p class="text-muted mx-2">&times;</p>
                                                    <p class="text-dark mb-2 font-weight-bold">
                                                        <span>{!! $product->currency_entity !!}</span>
                                                        <span>{{ $product->selling_price }}</span>
                                                    </p>
                                                    @if ($product->mrp)
                                                        <del class="text-muted ml-3">
                                                            (<span>{!! $product->currency_entity !!}</span>
                                                            <span>{{ $product->mrp }}</span>)
                                                        </del>
                                                    @endif
                                                </div>

                                                <hr>

                                                <p class="text-dark mb-2 font-weight-bold">
                                                    <span>{!! $product->currency_entity !!}</span>
                                                    <span>{{ $product->selling_price * $product->qty }}</span>
                                                </p>
                                            </div>
        
                                            <div class="status">
                                                <select name="status" id="status" class="form-control form-control-sm" data-route="{{ route('admin.order.product.status', $product->id) }}">
                                                    @foreach ($productStatus as $status)
                                                        <option value="{{ $status->value }}" {{ ($status->value == $product->status) ? 'selected' : '' }}>{{ $status->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <hr>

                        <h5 class="font-weight-bold text-primary">User</h5>

                        @if ($data->user_id == 0)
                            <div class="badge badge-danger rounded-0">Guest user</div>

                            <p class="small text-muted mb-0">Token</p>
                            <p class="text-dark">{{ $data->guest_token ? $data->guest_token : 'NA' }}</p>
                        @endif

                        <p class="small text-muted mb-0">Customer name</p>
                        <p class="text-dark">{{ $data->user_full_name ? $data->user_full_name : 'NA' }}</p>

                        <p class="small text-muted mb-0">Email ID</p>
                        <p class="text-dark">{{ $data->user_email ? $data->user_email : 'NA' }}</p>

                        <p class="small text-muted mb-0">Phone number</p>
                        <p class="text-dark">{{ $data->user_phone_no ? $data->user_phone_no : 'NA' }}</p>

                        <p class="small text-muted mb-0">Phone number ALT</p>
                        <p class="text-dark">{{ $data->user_phone_no_alt ? $data->user_phone_no_alt : 'NA' }}</p>

                        <p class="small text-muted mb-0">Whatsapp number</p>
                        <p class="text-dark">{{ $data->user_whatsapp_no ? $data->user_whatsapp_no : 'NA' }}</p>

                        <hr>

                        <h5 class="font-weight-bold text-primary">Delivery</h5>

                        <p class="small text-muted mb-0">Delivery method</p>
                        <p class="text-dark">{{ $data->delivery_method ? $data->delivery_method : 'NA' }}</p>

                        <div class="row">
                            <div class="col-md-3">
                                <p class="small text-muted mb-0">Shipping address</p>
                                <table class="table-sm table-striped table-hover">
                                    <tbody>
                                        <tr>
                                            <td><p class="text-muted mb-0">Name</p></td>
                                            <td class="text-right">
                                                <p class="text-dark mb-0">{{ $data->addressDetails->shipping_address_user_full_name }}</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><p class="text-muted mb-0">Phone no</p></td>
                                            <td class="text-right">
                                                <p class="text-dark mb-0">{{ $data->addressDetails->shipping_address_user_phone_no }}</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><p class="text-muted mb-0">Postcode</p></td>
                                            <td class="text-right">
                                                <p class="text-dark mb-0">{{ $data->addressDetails->shipping_address_postcode }}</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><p class="text-muted mb-0">Country</p></td>
                                            <td class="text-right">
                                                <p class="text-dark mb-0">{{ $data->addressDetails->shipping_address_country }}</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><p class="text-muted mb-0">State</p></td>
                                            <td class="text-right">
                                                <p class="text-dark mb-0">{{ $data->addressDetails->shipping_address_state }}</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><p class="text-muted mb-0">City</p></td>
                                            <td class="text-right">
                                                <p class="text-dark mb-0">{{ $data->addressDetails->shipping_address_city }}</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><p class="text-muted mb-0">Locality</p></td>
                                            <td class="text-right">
                                                <p class="text-dark mb-0">{{ $data->addressDetails->shipping_address_locality }}</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><p class="text-muted mb-0">Street address</p></td>
                                            <td class="text-right">
                                                <p class="text-dark mb-0">{{ $data->addressDetails->shipping_address_street_address }}</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><p class="text-muted mb-0">Landmark</p></td>
                                            <td class="text-right">
                                                <p class="text-dark mb-0">{{ $data->addressDetails->shipping_address_landmark }}</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><p class="text-muted mb-0">Type</p></td>
                                            <td class="text-right">
                                                <p class="text-dark mb-0">{{ $data->addressDetails->shipping_address_type }}</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-md-3">
                                <p class="small text-muted mb-0">Billing address</p>
                                <table class="table-sm table-striped table-hover">
                                    <tbody>
                                        <tr>
                                            <td><p class="text-muted mb-0">Name</p></td>
                                            <td class="text-right">
                                                <p class="text-dark mb-0">{{ $data->addressDetails->billing_address_user_full_name }}</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><p class="text-muted mb-0">Phone no</p></td>
                                            <td class="text-right">
                                                <p class="text-dark mb-0">{{ $data->addressDetails->billing_address_user_phone_no }}</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><p class="text-muted mb-0">Postcode</p></td>
                                            <td class="text-right">
                                                <p class="text-dark mb-0">{{ $data->addressDetails->billing_address_postcode }}</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><p class="text-muted mb-0">Country</p></td>
                                            <td class="text-right">
                                                <p class="text-dark mb-0">{{ $data->addressDetails->billing_address_country }}</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><p class="text-muted mb-0">State</p></td>
                                            <td class="text-right">
                                                <p class="text-dark mb-0">{{ $data->addressDetails->billing_address_state }}</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><p class="text-muted mb-0">City</p></td>
                                            <td class="text-right">
                                                <p class="text-dark mb-0">{{ $data->addressDetails->billing_address_city }}</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><p class="text-muted mb-0">Locality</p></td>
                                            <td class="text-right">
                                                <p class="text-dark mb-0">{{ $data->addressDetails->billing_address_locality }}</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><p class="text-muted mb-0">Street address</p></td>
                                            <td class="text-right">
                                                <p class="text-dark mb-0">{{ $data->addressDetails->billing_address_street_address }}</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><p class="text-muted mb-0">Landmark</p></td>
                                            <td class="text-right">
                                                <p class="text-dark mb-0">{{ $data->addressDetails->billing_address_landmark }}</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><p class="text-muted mb-0">Type</p></td>
                                            <td class="text-right">
                                                <p class="text-dark mb-0">{{ $data->addressDetails->billing_address_type }}</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <hr>

                        <h5 class="font-weight-bold text-primary">Payment</h5>

                        <p class="small text-muted mb-0">Payment method</p>
                        <p class="text-dark">{{ $data->payment_method ? $data->payment_method : 'NA' }}</p>

                        <p class="small text-muted mb-0">Breakdown</p>
                        <div class="row">
                            <div class="col-md-3">
                                <table class="table-sm table-striped table-hover">
                                    <tbody>
                                        <tr>
                                            <td><p class="text-muted mb-0">Cart value</p></td>
                                            <td class="text-right">
                                                <p class="text-dark mb-0">{{ $data->total_cart_amount }}</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><p class="text-muted mb-0">TAX</p></td>
                                            <td class="text-right">
                                                <p class="text-dark mb-0">
                                                    <small>({{ $data->tax_in_percentage }}%)</small>
                                                    +{{ $data->tax_in_amount }}
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><p class="text-muted mb-0">Shipping charge</p></td>
                                            <td class="text-right">
                                                <p class="text-dark mb-0">
                                                    +{{ $data->shipping_charge }}
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><p class="text-muted mb-0">Payment method charge</p></td>
                                            <td class="text-right">
                                                <p class="text-dark mb-0">
                                                    +{{ $data->payment_method_charge }}
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><p class="text-muted mb-0">Coupon discouont</p></td>
                                            <td class="text-right">
                                                <p class="text-dark mb-0">
                                                    -{{ $data->coupon_discount }}
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><p class="text-muted mb-0">Final order value</p></td>
                                            <td class="text-right">
                                                <p class="text-dark mb-0">
                                                    {{ $data->final_order_amount }}
                                                </p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        @if ($data->couponDetails)
                        <hr>

                        <h5 class="font-weight-bold text-primary">Coupon</h5>

                        <p class="small text-muted mb-0">Coupon details</p>
                        <p class="text-dark">Goto</p>

                        <p class="small text-muted mb-0">Details</p>
                        <div class="row">
                            <div class="col-md-3">
                                <table class="table-sm table-striped table-hover">
                                    <tbody>
                                        <tr>
                                            <td><p class="text-muted mb-0">Code</p></td>
                                            <td class="text-right">
                                                <p class="text-dark mb-0">{{ $data->couponDetails->coupon_code }}</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><p class="text-muted mb-0">Name</p></td>
                                            <td class="text-right">
                                                <p class="text-dark mb-0">{{ $data->couponDetails->coupon_name }}</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><p class="text-muted mb-0">Discount type</p></td>
                                            <td class="text-right">
                                                <p class="text-dark mb-0">{{ ($data->couponDetails->discount_type == 1) ? 'Flat' : 'Percentage' }}</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><p class="text-muted mb-0">Discount amount</p></td>
                                            <td class="text-right">
                                                <p class="text-dark mb-0">
                                                    @if ($data->couponDetails->discount_type == 1)
                                                        {{ $data->couponDetails->discount_amount }}
                                                    @else
                                                        {{ $data->couponDetails->discount_amount }}%
                                                    @endif
                                                </p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
    <script>
        $('select[name="status"]').on('change', function() {
            var val = $(this).find(':selected').val();
            var route = $(this).data('route');
            statusUpdate(route, val);
        });
    </script>
@endsection