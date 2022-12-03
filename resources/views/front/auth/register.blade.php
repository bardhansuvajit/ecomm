@extends('front.layout.app')

@section('page-title', 'register')

@section('section')
<div class="row justify-content-center">
    <div class="col-12 col-md-6 col-lg-4 mt-5">
        <div class="card shadow">
            <div class="card-body p-3">
                <form action="{{ route('front.user.create') }}" method="POST">@csrf
                    <h3 class="page_header">Register</h3>

                    <p id="loginText" class="subtitle1 fw-400 mb-4">Create new account</p>

                    <div class="row g-3">
                        <div class="col-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control form-control-sm @error('first_name') is-invalid @enderror" id="first_name" placeholder="First name" name="first_name" value="{{old('first_name')}}" autocomplete="first-name" maxlength="30" autofocus>
                                <label for="first_name">First name *</label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control form-control-sm @error('last_name') is-invalid @enderror" id="last_name" placeholder="Last name" name="last_name" value="{{old('last_name')}}" autocomplete="last-name" maxlength="30">
                                <label for="last_name">Last name *</label>
                            </div>
                        </div>
                        {{-- <div class="col-12 mt-0">
                            @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div> --}}
                    </div>

                    <div class="form-floating mb-3">
                        <input type="number" class="form-control form-control-sm @error('mobile_no') is-invalid @enderror" id="mobile_no" placeholder="Mobile number" name="mobile_no" value="{{old('mobile_no')}}" autocomplete="tel" maxlength="10">
                        <label for="mobile_no">Mobile number *</label>
                        @error('mobile_no')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input type="email" class="form-control form-control-sm @error('email') is-invalid @enderror" id="email" placeholder="Email address" name="email" value="{{old('email')}}" autocomplete="email" maxlength="50">
                        <label for="email">Email address (optional)</label>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-floating mb-2">
                        <input type="password" class="form-control form-control-sm @error('password') is-invalid @enderror" id="password" placeholder="Password" name="password" value="" autocomplete="none" maxlength="30">
                        <label for="password">Password *</label>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    {{-- <div class="form-floating mb-2">
                        <input type="text" class="form-control form-control-sm @error('referral') is-invalid @enderror" id="referral" placeholder="Referral code" name="referral" value="{{old('referral')}}" autocomplete="none" maxlength="10">
                        <label for="referral">Referral code (optional)</label>
                        @error('referral')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div> --}}

                    {{-- <div class="opt_text_holder">
                        <p class="multiple" for="agreeterms"><a href="#">Forgot password ?</a></p>
                    </div> --}}

                    <div class="d-flex justify-content-between mt-3">
                        <button type="submit" class="btn btn-primary" id="login_button" name="login_button"> Continue </button>
                        <a href="{{ route('front.user.login') }}" class="btn btn-secondary">Login ?</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    {{-- <div class="login-cont">
        <main class="form-signin">
            <form method="POST" action="{{ route('front.user.create') }}">@csrf
                <p class="display-4 mb-4">
                    <img src="{{ asset('images/logo/logo.png') }}" alt="" class="logo" style="height: 45px;">
                    {{ env('APP_NAME') }}
                </p>
                <h1 class="h3 mb-3 fw-normal">Please register</h1>
                
                <div class="form-floating">
                    <input type="text" class="form-control @error('referral_id') is-invalid @enderror" id="floatingReferralId" placeholder="Referral id" name="referral_id" value="{{ old('referral_id') }}" autocomplete="referral_id" autofocus>
                    <label for="floatingReferralId">Ref</label>
                    @error('referral_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-floating">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="floatingName" placeholder="name@example.com" name="name" value="{{ old('name') }}" autocomplete="name" required>
                    <label for="floatingName">Full name</label>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-floating">
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="floatingEmail" placeholder="name@example.com" name="email" value="{{ old('email') }}" autocomplete="email" required>
                    <label for="floatingEmail">Email address</label>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-floating">
                    <input type="number" class="form-control @error('mobile_number') is-invalid @enderror" id="floatingNumber" placeholder="name@example.com" name="mobile_number" value="{{ old('mobile_number') }}" autocomplete="mobile-number" required>
                    <label for="floatingNumber">Mobile number</label>
                    @error('mobile_number')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-floating">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="floatingPassword" placeholder="Password" name="password" required autocomplete="current-password">
                    <label for="floatingPassword">Password</label>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="checkbox mb-3">
                    <label>
                        <input type="checkbox" name="agree_to_terms" id="agree_to_terms" {{ old('agree_to_terms') ? 'checked' : '' }} value="agree"> I agree to terms & conditions
                    </label>
                </div>
                @error('agree_to_terms')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
                @if (Route::has('front.user.login'))
                    <a class="btn btn-link" href="{{ route('front.user.login') }}">
                        Back to login
                    </a>
                @endif
            </form>
        </main>
    </div> --}}
@endsection