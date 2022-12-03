<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <title>{{ env('APP_NAME') }} @yield('page-title')</title>

    <link rel="stylesheet" href="{{asset('./css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css"/>

    <link rel="stylesheet" href="{{asset('./css/common.css')}}">
    <link rel="stylesheet" href="{{asset('./css/front.css')}}">

    @yield('style')

</head>
<body>
    <div class="topbar">
        <div class="nav-part" id="onscroll-nav" style="top: 0px;">
            <nav class="container">
                <div class="nav-holder">
                    <div class="nav-logo">
                        <div class="collapse-holder">
                            <button type="button" class="sidebarToggle sidenav-trigger" data-bs-toggle="modal" data-bs-target="#sidebarModal">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                            </button>
                        </div>
                        <div class="logo-holder">
                            <a href="{{ url('/') }}">
                                {{ env('APP_NAME') }}
                                {{-- <img src="https://torzo.in/assets/images/static/main_logo_thumb.png" alt="torzo"> --}}
                            </a>
                        </div>
                    </div>
                    <div class="nav-mid">
                        <div class="top">
                            <form action="search" method="GET">
                                <div class="input-group">
                                    <label for="search-bar">search</label>
                                    <input id="search-bar" data-toggle="modal" data-target="#searchResult" type="search" name="q" placeholder="What are you looking for..." autocomplete="off">
                                    <div class="input-group-append">
                                        <button type="submit" id="search-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                                        </button>
                                    </div>
                                </div>
                                <div id="search-result-holder" style="display: none;">
                                    <div class="search-result">
                                        <p>Trending</p>
                                        <ul class="list-group">
                                            <a href="#" class="list-group-item list-group-item-action">
                                                <svg height="20" viewBox="0 0 48 48" width="20" xmlns="http://www.w3.org/2000/svg"><path d="M0 0h48v48h-48z" fill="none"/><path d="M25.99 6c-9.95 0-17.99 8.06-17.99 18h-6l7.79 7.79.14.29 8.07-8.08h-6c0-7.73 6.27-14 14-14s14 6.27 14 14-6.27 14-14 14c-3.87 0-7.36-1.58-9.89-4.11l-2.83 2.83c3.25 3.26 7.74 5.28 12.71 5.28 9.95 0 18.01-8.06 18.01-18s-8.06-18-18.01-18zm-1.99 10v10l8.56 5.08 1.44-2.43-7-4.15v-8.5h-3z" opacity=".9"/></svg>
                                                Mobiles</a>
                                            <a href="#" class="list-group-item list-group-item-action">
                                                <svg height="20" viewBox="0 0 48 48" width="20" xmlns="http://www.w3.org/2000/svg"><path d="M0 0h48v48h-48z" fill="none"/><path d="M25.99 6c-9.95 0-17.99 8.06-17.99 18h-6l7.79 7.79.14.29 8.07-8.08h-6c0-7.73 6.27-14 14-14s14 6.27 14 14-6.27 14-14 14c-3.87 0-7.36-1.58-9.89-4.11l-2.83 2.83c3.25 3.26 7.74 5.28 12.71 5.28 9.95 0 18.01-8.06 18.01-18s-8.06-18-18.01-18zm-1.99 10v10l8.56 5.08 1.44-2.43-7-4.15v-8.5h-3z" opacity=".9"/></svg>
                                                TVs</a>
                                            <a href="#" class="list-group-item list-group-item-action">
                                                <svg height="20" viewBox="0 0 48 48" width="20" xmlns="http://www.w3.org/2000/svg"><path d="M0 0h48v48h-48z" fill="none"/><path d="M25.99 6c-9.95 0-17.99 8.06-17.99 18h-6l7.79 7.79.14.29 8.07-8.08h-6c0-7.73 6.27-14 14-14s14 6.27 14 14-6.27 14-14 14c-3.87 0-7.36-1.58-9.89-4.11l-2.83 2.83c3.25 3.26 7.74 5.28 12.71 5.28 9.95 0 18.01-8.06 18.01-18s-8.06-18-18.01-18zm-1.99 10v10l8.56 5.08 1.44-2.43-7-4.15v-8.5h-3z" opacity=".9"/></svg>
                                                Electronics</a>
                                        </ul>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="nav-last-sec">
                        <ul class="highlight-links">
                            <li class="cart-container me-0">
                                {{-- <a href="#pincodeModal" data-bs-toggle="modal" class="btn btn-sm" id="header_location"> --}}
                                <a href="javascript: void(0)" class="btn btn-sm userPincodeOpen" id="header_location">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map-pin"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                    {{-- <span class="highlight" id="user_postcode">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-info"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                                    </span> --}}
                                </a>
                            </li>
                            <li class="cart-container">
                                <a href="{{ route('front.cart.index') }}" class="btn btn-sm" id="header_cart">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                                    <span class="highlight" id="cartCountShow">
                                        @if ($cartCount > 0)
                                        <span id="user_cartCountHeader">
                                            {{ ($cartCount > 0) ? $cartCount : '' }}
                                        </span>
                                        @endif
                                    </span>
                                </a>
                            </li>
                            <li class="more-container">
                                <div class="dropdown">
                                    <a class="btn btn-sm btn-secondary" href="javascript: void(0)" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                        More
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink">
                                        <li><a class="dropdown-item" href="#">Sell on Torzo</a></li>
                                        <li><a class="dropdown-item" href="#">Refer a friend</a></li>
                                        <li><a class="dropdown-item" href="#">Request a service</a></li>
                                        <li><a class="dropdown-item" href="#">Request a product</a></li>
                                        <div class="dropdown-divider"></div>
                                        <li><a class="dropdown-item" href="#">Request a product</a></li>
                                    </ul>
                                </div>
                            </li>
                            <li id="login__holder">
                                @auth
                                    {{-- <a href="{{ route('front.user.profile') }}" class="btn btn-sm btn-primary">{{ auth()->guard('web')->user()->first_name }}</a> --}}

                                    <div class="dropdown">
                                        <a class="btn btn-sm btn-primary dropdown-toggle" href="javascript: void(0)" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                            {{ substr(auth()->guard('web')->user()->first_name, 0, 8) }}
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink">
                                            <li><a class="dropdown-item fw-600 small text-muted" href="{{ route('front.user.order') }}">My Orders</a></li>
                                            <li><a class="dropdown-item fw-600 small text-muted" href="{{ route('front.user.profile') }}">My Profile</a></li>
                                            <li><a class="dropdown-item fw-600 small text-muted" href="{{ route('front.user.address') }}">My Address</a></li>
                                            <li><a class="dropdown-item fw-600 small text-muted" href="{{ route('front.user.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a></li>
                                        </ul>
                                    </div>
                                @else
                                    <a href="{{ route('front.user.login') }}" class="btn btn-sm btn-primary">Login</a>
                                @endauth
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>

    <div class="modal left fade" id="sidebarModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header p-2">
                    <h5 class="modal-title">
                        <img src="{{ asset('images/logo/logo.png') }}" alt="" class="logo">
                        {{ env('APP_NAME') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0 text-start">
                    <div class="list-group rounded-0">
                        <a href="{{ url('/') }}" class="list-group-item list-group-item-action {{ (url()->current() == url('/')) ? 'active' : '' }}" aria-current="true">
                            <p class="mb-1">Home</p>
                        </a>
                        @auth
                            <a href="{{ route('front.user.order') }}" class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                                </div>
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Orders &amp; Returns</div>
                                    <p class="small mb-0">View Orders &amp; Returns</p>
                                </div>
                                {{-- <span class="badge bg-primary rounded-pill">14</span> --}}
                            </a>
                            <a href="{{ route('front.coming.soon') }}" class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-briefcase"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                                </div>
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Self Business</div>
                                    <p class="small mb-0">View self business details</p>
                                </div>
                            </a>
                            <a href="{{ route('front.coming.soon') }}" class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="icon">
                                    <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 203.86 300" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round"><g id="Group_21638" data-name="Group 21638"><path id="Path_26915" data-name="Path 26915" class="cls-1" d="M135.76,28.35H185L203.86,0h-185L0,28.35H32.1c32.5,0,62.5,2.5,74.51,29.7H19L.15,86.39h110c0,20.4-16.9,51.65-72.8,51.65h-27v26.5L118.74,300H167L54.85,160c46.15-2.5,89.46-28.31,95.7-73.56H185L203.86,58.1h-53.8a62.85,62.85,0,0,0-14.3-29.75Z"/></g></svg>
                                </div>
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Earnings</div>
                                    <p class="small mb-0">View earning details</p>
                                </div>
                            </a>
                            <a href="{{ route('front.coming.soon') }}" class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-globe"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                                </div>
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Company Business</div>
                                    <p class="small mb-0">View company business details</p>
                                </div>
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="pincodeModal" tabindex="-1" aria-labelledby="pincodeModalLabel" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pincodeModalLabel">Your delivery pincode</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>

    {{-- <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body loginModalBody">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div id="loginForm__holder">
                        <form action="{{ route('api.user.check') }}" id="loginForm" method="post">@csrf
                            <h3 class="page_header">Login</h3>

                            <p id="loginText" class="subtitle1 fw-400 mb-4">login with mobile number &amp; password</p>

                            <div class="form-floating mb-3">
                                <input type="number" class="form-control form-control-sm @error('loginph_number') is-invalid @enderror" id="loginph_number" placeholder="Mobile number" name="loginph_number" value="" autocomplete="mobile-number" maxlength="10">
                                <label for="loginph_number">Mobile number *</label>
                                @error('loginph_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-floating mb-2">
                                <input type="password" class="form-control form-control-sm @error('login_password') is-invalid @enderror" id="login_password" placeholder="Password" name="login_password" value="" autocomplete="none" maxlength="30">
                                <label for="login_password">Password *</label>
                                @error('login_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="opt_text_holder">
                                <p class="multiple" for="agreeterms"><a href="#">Forgot password ?</a></p>
                            </div>

                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary" id="login_button" name="login_button"> Continue </button>
                                <button type="button" data-dismiss="modal" data-toggle="modal" data-target="#signupModal" class="btn btn-secondary" id="switchTo_signup"> Create new account ? </button>
                            </div>
                        </form>
                        <div class="curved-div"></div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    {{-- <div class="modal fade" id="signupModal" tabindex="-1" aria-labelledby="signupModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog moda l-dialog-centered">
            <div class="modal-content">
                <div class="modal-body signupModalBody" style="overflow: hidden">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="font-size: 50px;">&times;</span>
                    </button>
                    <div id="signupForm__holder">
                        <form id="signupForm" method="post">
                            <h3 class="page_header">Signup</h3>
    
                            <p id="signupText" class="subtitle1 fw-400 mb-4">Create new account</p>
    
                            <div class="input-box" id="signup__input1">
                                <input type="number" name="signupph_number" id="signupph_number" autocomplete="off" required>
                                <label id="signupph_numberLabel">Mobile Number</label>
                            </div>
    
                            <div class="input-box" id="signup__input2">
                                <input type="password" name="signup_password" id="signup_password" autocomplete="off" required>
                                <label id="signup_passwordLabel">Create password</label>
                            </div>
    
                            <div class="opt_text_holder">
                                <p class="multiple" for="agreeterms"><a href="#">signup terms &amp; conditions</a></p>
                                <!-- <p class="multiple" for="agreeterms"><a href="#">forgot password ?</a></p> -->
                            </div>
    
                            <div class="submit_btn">
                                <button type="submit" class="continue-btn" id="signup_button" name="signup_button"> Continue </button>
                                <button type="button" data-dismiss="modal" data-toggle="modal" data-target="#loginModal" class="cancel-btn" id="switchTo_login"> Login ? </button>
                            </div>
                        </form>
                        <div class="curved-div"></div>
                    </div>
    
                </div>
            </div>
        </div>
    </div> --}}

    <div class="container master-container">
        @yield('section')
    </div>

    <form action="{{ route('front.user.logout') }}" id="logout-form" method="post" class="d-none">@csrf</form>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('./js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('./js/front.js') }}"></script>
    <script src="{{ asset('./js/custom.js') }}"></script>

    <script>
        @if(Session::has('success'))
            toastFire('success', '{{Session::get("success")}}');
        @endif

        @if(Session::has('failure'))
            toastFire('error', '{{Session::get("failure")}}');
        @endif
    </script>

    @yield('script')

</body>
</html>