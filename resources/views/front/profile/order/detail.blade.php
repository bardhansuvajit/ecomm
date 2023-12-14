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
                                    <img src="http://127.0.0.1:8000/uploads/product-image/6UMKeN3lZ4pgc2rSsFio_medium-thumb_.jpeg" alt="" class="w-100">
                                </div>
                            </div>
                            <div class="content-section">
                                <p class="height-2 text-dark mb-2">{{ $product->product_title }}</p>

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
                    <a href="javascript:demoFromHTML()" class="btn btn-sm btn-dark rounded-0">Invoice</a>

                    <div id="content"></div>

                    {{-- <a href="javascript: void(0)" class="btn btn-sm btn-dark rounded-0" onclick="downloadInvoice()">Invoice</a> --}}
                </div>
            </div>
        </section>
        @endif
    </div>
</div>
@endsection

@section('script')
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.min.js"></script> --}}
    {{-- <script src="https://unpkg.com/jspdf@latest/dist/jspdf.umd.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>

    <script>
        function demoFromHTML() {
            // Landscape export, 2×4 inches
            // const doc = new jsPDF({
            //     orientation: "landscape",
            //     unit: "in",
            //     format: [4, 2]
            // });

            // doc.text("Hello world!", 1, 1);
            // doc.save("two-by-four.pdf");

            var pdf = new jsPDF('p', 'pt', 'letter');
            // source can be HTML-formatted string, or a reference
            // to an actual DOM element from which the text will be scraped.
            source = $('#content')[0];

            // we support special element handlers. Register them with jQuery-style 
            // ID selector for either ID or node name. ("#iAmID", "div", "span" etc.)
            // There is no support for any other type of selectors 
            // (class, of compound) at this time.
            specialElementHandlers = {
                // element with id of "bypass" - jQuery style selector
                '#bypassme': function (element, renderer) {
                    // true = "handled elsewhere, bypass text extraction"
                    return true
                }
            };
            margins = {
                top: 80,
                bottom: 60,
                left: 40,
                width: 522
            };
            // all coords and widths are in jsPDF instance's declared units
            // 'inches' in this case
            pdf.fromHTML(
                source, // HTML string or DOM elem ref.
                margins.left, // x coord
                margins.top, { // y coord
                    'width': margins.width, // max width of content on PDF
                    'elementHandlers': specialElementHandlers
                },

                function (dispose) {
                    // dispose: object with X, Y of the last line add to the PDF 
                    //          this allow the insertion of new lines after html
                    pdf.save('Test.pdf');
                }, margins
            );
        }
    </script>
@endsection
