@extends('front.layout.app')

@section('page-title', 'login')

@section('section')
<div class="row justify-content-center">
    <div class="col-12 col-md-6 col-lg-4 mt-5">
        <div class="card shadow">
            <div class="card-body p-3">
                <form action="{{ route('front.user.check') }}" method="POST">@csrf
                    <h3 class="page_header">Login</h3>

                    <p id="loginText" class="subtitle1 fw-400 mb-4">login with mobile number &amp; password</p>

                    <div class="form-floating mb-3">
                        <input type="number" class="form-control form-control-sm @error('mobile_no') is-invalid @enderror" id="mobile_no" placeholder="Mobile number" name="mobile_no" value="{{old('mobile_no')}}" autocomplete="mobile-number" maxlength="10" autofocus>
                        <label for="mobile_no">Mobile number *</label>
                        @error('mobile_no')
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
        
                    <div class="opt_text_holder">
                        <p class="multiple" for="agreeterms"><a href="#">Forgot password ?</a></p>
                    </div>
        
                    <div class="d-flex justify-content-between">
                        <input type="hidden" name="redirect_url" value="{{$redirect_url}}">
                        <button type="submit" class="btn btn-primary" id="login_button" name="login_button"> Continue </button>

                        <a href="{{ route('front.user.register') }}" class="btn btn-secondary">Create new account ?</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection