@extends('admin.layout.app')

@section('page-title', 'login')

@section('section')
    <div class="login-cont">
        <main class="form-signin text-center">
            <form method="POST" action="{{ route('admin.check') }}">@csrf
                <p class="display-6 mb-4">ADMIN</p>
                <h1 class="h3 mb-3 fw-normal">Please sign in</h1>
    
                <div class="form-floating">
                    <input type="text" class="form-control @error('username') is-invalid @enderror" id="floatingInput" placeholder="name@example.com" name="username" value="{{ old('username') }}" autocomplete="username" required autofocus>
                    <label for="floatingInput">Username</label>

                    @error('username')
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
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}
                    </label>
                </div>
                <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
            </form>
        </main>
    </div>
@endsection