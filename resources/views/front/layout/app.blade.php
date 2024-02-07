<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-type" content="text/html; charset=utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta name="robots" content="noodp">
        <meta property="og:type" content="website">
        <meta name="og_site_name" property="og:site_name" content="torzo.in">
        <title>@yield('page-title')</title>

        <link rel="stylesheet" href="{{ asset('frontend-assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend-assets/css/swiper-bundle.min.css') }}">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="{{ asset('frontend-assets/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend-assets/css/responsive.css') }}">

        <meta name="title" content="@yield('meta-title')">
        <meta name="description" content="@yield('meta-description')"/>

        @yield('style')
    </head>
    <body>
        @if (!request()->is('checkout'))
        <nav class="navbar bg-body-tertiary" id="onscroll-nav">
            <div class="container">
                <div class="nav-logo">
                    <div class="nav-toggler">
                        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbarMobileOnly" aria-controls="offcanvasNavbarMobileOnlyLabel" aria-label="Mobile sidebar">
                            <i class="material-icons">menu</i>
                        </button>
                    </div>

                    <a class="navbar-brand" href="{{ route('front.home') }}">
                        <img src="{{ asset($officeInfo->primary_logo) }}" alt="">
                    </a>
                </div>

                <div class="nav-search">
                    <div class="search-section">
                        <form action="search" method="GET">
                            <div class="input-group">
                                <input type="search" class="form-control" name="q" placeholder="What are you looking for..." autocomplete="off" id="search-bar">

                                <span class="input-group-text">
                                    <button type="submit" id="search-icon">
                                        <i class="material-icons">search</i>
                                    </button>
                                </span>
                            </div>
                            <div id="search-result-holder">
                                <div class="search-result">
                                    <p class="small text-muted mb-2 ms-3">Trending</p>
                                    <div class="list-group">
                                        <a href="#" class="list-group-item list-group-item-action"> 
                                            <i class="material-icons">youtube_searched_for</i> 
                                            Mobiles
                                        </a>
                                        <a href="#" class="list-group-item list-group-item-action"> 
                                            <i class="material-icons">youtube_searched_for</i> 
                                            Mobile under 10000
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="nav-quick">
                    <div class="icons-holder">
                        <a href="javascript: void(0)" class="btn btn-circle" onclick="quickCartListUpdate()">
                            <i class="material-icons">shopping_cart</i>
                            <span class="highlight" id="cartCountShow">
                                @if ($cartCount > 0)
                                <span id="user_cartCountHeader">
                                    {{ ($cartCount > 0) ? $cartCount : '' }}
                                </span>
                                @endif
                            </span>
                        </a>

                        <a href="javascript: void(0)" data-bs-toggle="offcanvas" data-bs-target="#locationBackdrop" class="btn btn-circle d-des">
                            <i class="material-icons">location_on</i>
                        </a>

                        <div id="login-container" class="d-inline-block">
                            @if (auth()->guard('web')->check())
                                <div class="btn-group user-detail">
                                    <a class="dropdown-toggle" href="javascript: void(0)" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        {{ auth()->guard('web')->user()->first_name ? auth()->guard('web')->user()->first_name : 'Profile' }}
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <h6 class="dropdown-header">
                                                {{ auth()->guard('web')->user()->first_name.' '.auth()->guard('web')->user()->last_name }}
                                            </h6>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('front.user.account') }}">Account</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('front.user.order.index') }}">Orders</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('front.user.profile.index') }}">Profile</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="javascript: void(0)" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
                                        </li>
                                    </ul>
                                </div>
                            @else
                                <a href="#loginModal" data-bs-toggle="modal" class="btn btn-dark d-des">
                                    Login
                                </a>
                                <a href="#loginModal" data-bs-toggle="modal" class="btn btn-circle m-des">
                                    <i class="material-icons">account_circle</i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbarMobileOnly" aria-labelledby="offcanvasNavbarMobileOnlyLabel">
                    <div class="offcanvas-header">
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">An item</li>
                            <li class="list-group-item">A second item</li>
                            <li class="list-group-item">A third item</li>
                            <li class="list-group-item">A fourth item</li>
                            <li class="list-group-item">And a fifth one</li>
                        </ul>
                    </div>
                </div>

                {{-- <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbarMobileOnly">
                    <div class="offcanvas-header">
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body d-block">
                        <div class="row">
                            here
                        </div>
                    </div>
                </div> --}}
            </div>
        </nav>
        @endif

        @if (request()->is('checkout'))
            <div class="container main-container mt-20px">
        @else
            <div class="container main-container">
        @endif

            @yield('content')
        </div>

        <footer>
            <div class="container">
                <div class="row mb-4">
                    <div class="col-md-4 text-center text-md-start mb-4">
                        <form method="get" action="{{ route('front.newsletter.subscribe') }}" id="newsletterSubscribeForm">@csrf
                            <h5 class="text-light">Subscribe to our newsletter</h5>
                            <p class="text-light">Monthly digest of whats new and exciting from us.</p>
                            <div class="d-flex w-100 gap-2">
                                <label for="newsletter" class="visually-hidden">Email address</label>
                                <input id="newsletter" type="email" class="form-control" placeholder="Email address" maxlength="50">
                                <button class="btn btn-sm btn-primary rounded-0" type="submit">Subscribe</button>
                            </div>
                        </form>
                    </div>

                    <div class="col-md-4"></div>

                    <div class="col-md-4 text-center text-md-end mb-4">
                        <h5 class="text-light">Contact us</h5>
                        <p class="text-light">You can get in touch with us from the followings</p>
                        <ul class="nav flex-column">
                            <li>
                                <a href="">
                                    <div class="tags-holder">
                                        <span class="icon"><i class="material-icons">mail</i></span>
                                        <span class="text">support@torzo.in</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <div class="tags-holder">
                                        <span class="icon"><i class="material-icons">call</i></span>
                                        <span class="text">9876543210</span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="row border-top pt-4">
                    <div class="col-md-12 text-center">
                        <ul class="list-unstyled d-flex justify-content-center">
                            @foreach ($contentPages as $page)
                                @if ($page->status != 1) @continue @endif

                                <li class="me-3">
                                    <a class="" href="{{ route('front.page.'.$page->page) }}">{!! $page->title !!}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="col-md-12 text-center">
                        <p class="mb-0">&copy; {{ date('Y') }} {{ $officeInfo->full_name }} All rights reserved.</p>
                    </div>
                </div>

                {{-- <div class="bottom-part d-flex justify-content-between pt-4 mt-4 border-top">
                    <p class="small mb-0">&copy; {{ date('Y') }} Company, Inc. All rights reserved.</p>
                    <ul class="list-unstyled d-flex">
                        <li class="ms-3"><a class="link-dark" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#twitter"/></svg></a></li>
                        <li class="ms-3"><a class="link-dark" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#instagram"/></svg></a></li>
                        <li class="ms-3"><a class="link-dark" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#facebook"/></svg></a></li>
                    </ul>
                </div> --}}
            </div>
        </footer>

        @if (!request()->is('checkout'))
            @include('front.quick.cart')
        @endif

        @include('front.quick.currency')
        @include('front.quick.coupons')

        {{-- @guest --}}
        @include('front.quick.login')
        @include('front.quick.register')
        {{-- @endguest --}}

        <div id="access_blocked">
            <div class="rotate_notice">
                <div class="icon"><i class="material-icons">screen_rotation</i></div>
                <div class="text"><p class="subtitle1">Please rotate your device</p></div>
            </div>
        </div>

        <div class="sticky-section"></div>
        <form id="logout-form" action="{{ route('front.user.logout') }}" method="POST" class="d-none">@csrf</form>

        <script src="{{ asset('packages/jquery-3.7.1.min.js') }}"></script>
        <script src="{{ asset('frontend-assets/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('frontend-assets/js/swiper-bundle.min.js') }}"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="{{ asset('frontend-assets/js/custom.js') }}"></script>

        <script>
            @if(Session::has('success'))
                toastFire('success', '{{Session::get("success")}}');
            @endif

            @if(Session::has('failure'))
                toastFire('error', '{{Session::get("failure")}}');
            @endif

            @if (!auth()->guard('web')->check())
                document.onreadystatechange = function () {
                    if (getQuery('login') == 'true') {
                        loginModalEl.show();
                    }
                    if (getQuery('register') == 'true') {
                        registerModalEl.show();
                    }
                }
            @endif
        </script>

        @yield('script')
    </body>
</html>
