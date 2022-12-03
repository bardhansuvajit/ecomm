@extends('front.layout.app')

@section('page-title', 'Checkout')

@section('section')
<section class="checkout-detail">
    <div class="row mx-0 mb-5">
        <form action="{{ route('front.checkout.order.place') }}" method="POST" class="p-0">@csrf
            @php
                $totalPrice = $totalQty = 0;

                foreach($data as $cartKey => $cart) {
                    $totalPrice += ($cart->productDetails->offer_price == null) ? $cart->productDetails->price : $cart->productDetails->offer_price;
                    $totalQty += $cart->qty;
                }
            @endphp
            <div class="col-md-8">
                <div class="row">
                    <div class="col-12"><p class="text-muted">User information</p></div>

                    <div class="col-12 col-md-6 mb-3">
                        <div class="form-floating">
                            <input type="text" class="form-control form-control-sm @error('name') is-invalid @enderror" id="floatingName" placeholder="Full name" name="name" value="{{ auth()->guard('web')->check() ? auth()->guard('web')->user()->name : old('name') }}" autocomplete="name" required>
                            <label for="floatingName">Full name *</label>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12 col-md-6 mb-3">
                        <div class="form-floating">
                            <input type="number" class="form-control form-control-sm @error('mobile_number') is-invalid @enderror" id="floatingNumber" placeholder="9876XXXXX0" name="mobile_number" value="{{ auth()->guard('web')->check() ? auth()->guard('web')->user()->mobile_no : old('mobile_number') }}" autocomplete="mobile-number" required>
                            <label for="floatingNumber">Mobile number *</label>
                            @error('mobile_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12 col-md-6 mb-3">
                        <div class="form-floating">
                            <input type="email" class="form-control form-control-sm @error('email') is-invalid @enderror" id="floatingEmail" placeholder="name@example.com" name="email" value="{{ auth()->guard('web')->check() ? auth()->guard('web')->user()->email : old('email') }}" autocomplete="email">
                            <label for="floatingEmail">Email address *</label>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12"><p class="text-muted">Address information</p></div>

                    <div class="col-12 col-md-6 mb-3">
                        <div class="form-floating">
                            <input type="number" class="form-control form-control-sm @error('pincode') is-invalid @enderror" id="pincode" placeholder="XXXXXX" name="pincode" value="{{ old('pincode') }}" autocomplete="mobile-number" required>
                            <label for="pincode">Pincode *</label>
                            @error('pincode')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12 col-md-6 mb-3">
                        <div class="form-floating">
                            <textarea name="street_address" class="form-control form-control-sm @error('street_address') is-invalid @enderror" placeholder="Enter street address" id="street_address"></textarea>
                            <label for="street_address">Street address *</label>
                            @error('street_address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12 col-md-6 mb-3">
                        <div class="form-floating">
                            <input type="text" class="form-control form-control-sm @error('landmark') is-invalid @enderror" id="landmark" placeholder="Enter landmark" name="landmark" value="{{ old('landmark') }}" autocomplete="landmark">
                            <label for="landmark">Landmark</label>
                            @error('landmark')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-6 col-md-6 mb-3">
                        <div class="form-floating">
                            <input type="text" class="form-control form-control-sm @error('city') is-invalid @enderror" id="city" placeholder="Enter city" name="city" value="{{ old('email') }}" autocomplete="city">
                            <label for="city">City *</label>
                            @error('city')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-6 col-md-6 mb-3">
                        <div class="form-floating">
                            <input type="text" class="form-control form-control-sm @error('state') is-invalid @enderror" id="state" placeholder="Enter state" name="state" value="{{ old('email') }}" autocomplete="state">
                            <label for="state">State *</label>
                            @error('state')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Usually delivered in 2-5 days</h5>
                        {{-- <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6> --}}
                        <p class="card-text">Reach us for any queries.</p>
                        <a href="#" class="card-link">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone-call"><path d="M15.05 5A5 5 0 0 1 19 8.95M15.05 1A9 9 0 0 1 23 8.94m-1 7.98v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                            9876543210
                        </a>
                        <a href="#" class="card-link">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke="#25D366"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                            9876543210
                        </a>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-body">
                        <h5 class="card-title">Earn upto <span class="display-6">&#8377; 1000</span></h5>
                        <p class="card-text">Complete payment & earn assured cashback on every purchase</p>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

{{-- cart next page hightlight - only mobile --}}
<nav class="navbar fixed-bottom redirect_buttons_mobile">
    <div class="row gx-3 mx-0">
        <div class="col-6">
            <a href="{{ route('front.cart.index') }}" class="btn btn-secondary text-start w-100">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg>
                Cart
            </a>
        </div>
        <div class="col-6">
            <a href="checkout" class="btn btn-primary text-end w-100">
                Payment
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </a>
        </div>
    </div>
</nav>
@endsection