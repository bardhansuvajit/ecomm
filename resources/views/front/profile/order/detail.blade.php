@extends('front.layout.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-9">
        <section id="orders">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="page-head">
                        <div class="redirect me-3">
                            {{-- <a href="javascript: void(0)" onclick="history.back(-1)"> --}}
                            <a href="{{ route('front.user.order.index') }}">
                                <i class="material-icons">keyboard_arrow_left</i>
                            </a>
                        </div>
                        <div class="text">
                            <h5>Order id #{{ $data->order_no }}</h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="row justify-content-center mb-4">
                        <div class="col-3">
                            <img src="{{ asset('uploads/static-svgs/undraw_order_confirmed_re_g0if.svg') }}" alt="order-placed" class="w-100">
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-12 text-center">
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
                    <button onclick="generatePDF()" class="btn btn-sm btn-dark rounded-0">Invoice</button>
                </div>
            </div>
        </section>
        @endif

        {{-- @if ($data->orderProducts)
        <section id="order-products">
            <div class="d-flex">
                @foreach ($data->orderProducts as $product)
                    <div class="single-order-product">
                        <a href="{{ route('front.product.detail', $product->product_slug) }}" target="_blank">
                            <div class="image-section">
                                <div class="image-holder">
                                    <img src="http://127.0.0.1:8000/uploads/product-image/6UMKeN3lZ4pgc2rSsFio_medium-thumb_.jpeg" alt="" class="w-100">
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
                    <button onclick="generatePDF()" class="btn btn-sm btn-dark rounded-0">Invoice</button>
                </div>
            </div>
        </section>
        @endif --}}
    </div>
</div>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>

    <script>
        function generatePDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            doc.setFontSize(20);
            doc.text('Invoice', 14, 22);

            doc.setFontSize(10);
            doc.text('Company Details', 14, 30);
            doc.text('Company Name: {{ applicationSettings()->application_name }}', 14, 35);
            doc.text('Address: lorem ipsum dolor sit', 14, 40);
            doc.text('Email: test@test.com', 14, 45);
            doc.text('Phone: 022-0222-2222', 14, 50);

            doc.text('Customer Details', 14, 60);
            doc.text('Name: {{ $data->user_full_name }}', 14, 65);
            doc.text('Address: {{ $data->address }}', 14, 70);
            doc.text('Email: {{ $data->user_email }}', 14, 75);
            doc.text('Phone: {{ $data->user_phone_no }}', 14, 80);

            doc.text('Invoice Details', 14, 90);
            doc.text('Invoice Date: {{ $data->created_at }}', 14, 95);
            doc.text('Due Date: {{ $data->due_date }}', 14, 100);
            doc.text('Order Number: {{ $data->order_no }}', 14, 105);

            const headers = [["Description", "Quantity", "Unit Price", "Total"]];
            const data = [
                @foreach ($data->orderProducts as $item)
                ["{!! $item->product_title !!}", "{{ $item->qty }}", "{{ $item->selling_price }}", "{{ $item->qty * $item->selling_price }}"],
                @endforeach
            ];

            doc.autoTable({
                head: headers,
                body: data,
                startY: 110,
                theme: 'grid',
                headStyles: {
                    fillColor: [255, 255, 255],
                    textColor: [0, 0, 0]
                },
                bodyStyles: {
                    fillColor: [255, 255, 255],
                    textColor: [0, 0, 0]
                },
                styles: {
                    lineColor: [0, 0, 0],
                    lineWidth: 0.01
                }
            });

            doc.text('Total Amount', 14, doc.autoTable.previous.finalY + 10);
            doc.text('{{ $data->final_order_amount }}', 14, doc.autoTable.previous.finalY + 15);

            doc.save('{{ $data->order_no }}-{{ date("Y-m-d H:i:s") }}.pdf');
        }
    </script>
@endsection
