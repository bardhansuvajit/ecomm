@extends('front.layout.app')

@section('page-title', 'Checkout')

@section('section')
<section class="product-detail mb-3">
    <div class="row mx-0">
        <form action="{{ route('front.checkout.order.place') }}" method="POST">@csrf
            @php
                $totalPrice = $totalQty = 0;

                foreach($data as $cartKey => $cart) {
                    $totalPrice += ($cart->productDetails->offer_price == null) ? $cart->productDetails->price : $cart->productDetails->offer_price;
                    $totalQty += $cart->qty;
                }
            @endphp
            <div class="col-md-8">
                <div class="row">
                    <div class="col-12">
                        <p class="text-muted">User information</p>
                    </div>

                    <div class="col-6 col-md-6 mb-3">
                        <div class="form-floating">
                            <input type="text" class="form-control form-control-sm @error('name') is-invalid @enderror" id="floatingName" placeholder="Full name" name="name" value="{{ auth()->guard('web')->check() ? auth()->guard('web')->user()->name : old('name') }}" autocomplete="name" required>
                            <label for="floatingName">Full name</label>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-6 col-md-6 mb-3">
                        <div class="form-floating">
                            <input type="number" class="form-control form-control-sm @error('mobile_number') is-invalid @enderror" id="floatingNumber" placeholder="9876XXXXX0" name="mobile_number" value="{{ auth()->guard('web')->check() ? auth()->guard('web')->user()->mobile_no : old('mobile_number') }}" autocomplete="mobile-number" required>
                            <label for="floatingNumber">Mobile number</label>
                            @error('mobile_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-6 col-md-6 mb-3">
                        <div class="form-floating">
                            <input type="email" class="form-control form-control-sm @error('email') is-invalid @enderror" id="floatingEmail" placeholder="name@example.com" name="email" value="{{ auth()->guard('web')->check() ? auth()->guard('web')->user()->email : old('email') }}" autocomplete="email">
                            <label for="floatingEmail">Email address</label>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <p class="text-muted">Address information</p>
                    </div>

                    <div class="col-6 col-md-6 mb-3">
                        <div class="form-floating">
                            <input type="text" class="form-control form-control-sm @error('pincode') is-invalid @enderror" id="pincode" placeholder="" name="pincode" value="{{ old('pincode') }}" autocomplete="pincode" required>
                            <label for="pincode">Pincode</label>
                            @error('pincode')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-6 col-md-6 mb-3">
                        <div class="form-floating">
                            <input type="text" class="form-control form-control-sm @error('city') is-invalid @enderror" id="city" placeholder="" name="city" value="{{ old('city') }}" autocomplete="city" required>
                            <label for="city">City</label>
                            @error('city')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-6 col-md-6 mb-3">
                        <div class="form-floating">
                            <input type="text" class="form-control form-control-sm @error('state') is-invalid @enderror" id="state" placeholder="" name="state" value="{{ old('state') }}" autocomplete="state" required>
                            <label for="state">State</label>
                            @error('state')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-6 col-md-6 mb-3">
                        <div class="form-floating">
                            <input type="text" class="form-control form-control-sm @error('country') is-invalid @enderror" id="country" placeholder="" name="country" value="India" autocomplete="country" required>
                            <label for="country">Country</label>
                            @error('country')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12 col-md-6 mb-3">
                        <div class="form-floating">
                            {{-- <input type="text" class="form-control form-control-sm @error('name') is-invalid @enderror" id="floatingName" placeholder="" name="name" value="India" autocomplete="name" required> --}}
                            <textarea name="street_address" id="street_address" class="form-control form-control-sm @error('street_address') is-invalid @enderror">{{ old('street_address') }}</textarea>
                            <label for="street_address">Street address</label>
                            @error('street_address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-6 text-end">
                <div class="price-details mt-4">
                    <p>Total : &#8377; {{ number_format($totalPrice) }}</p>
                    <p>Quantity : {{ number_format($totalQty) }}</p>

                    <button type="submit" class="btn btn-primary w-100">Place Order</button>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection