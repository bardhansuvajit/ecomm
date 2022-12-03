<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <title>{{ env('APP_NAME') }} Admin | @yield('page-title')</title>

    <link rel="stylesheet" href="{{asset('./css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="{{asset('./css/common.css')}}">
    <link rel="stylesheet" href="{{asset('./css/admin.css')}}">
</head>
<body>
    @if(!request()->is('admin/login'))
    <section class="w-100 admin-body">
        <header class="d-flex flex-wrap justify-content-between" id="header">
            <div class="logo text-center col-6 col-md-3">
                <ul class="nav col-12 col-md-9 mb-md-0 d-flex">
                    <li class="d-inline-block d-md-none">
                        <a href="javascript: void(0)" class="nav-link px-2 link-secondary" id="admin-sidebar-toggle">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                        </a>
                    </li>
                    <li><a href="{{ route('admin.dashboard') }}" class="nav-link px-2 link-secondary"><span class="d-none d-md-inline-block">Sarbojaya</span> Admin</a></li>
                </ul>
            </div>
            <div class="content col-md-6 d-none d-md-block">
                <ul class="nav col-12 mb-2 justify-content-center mb-md-0">
                    {{-- <li><a href="{{ route('admin.dashboard') }}" class="nav-link px-2 link-secondary">Home</a></li>
                    <li><a href="#" class="nav-link px-2 link-dark">Features</a></li>
                    <li><a href="#" class="nav-link px-2 link-dark">Pricing</a></li>
                    <li><a href="#" class="nav-link px-2 link-dark">FAQs</a></li>
                    <li><a href="#" class="nav-link px-2 link-dark">About</a></li> --}}
                </ul>
            </div>
            <div class="handy col-6 col-md-3">
                <div class="d-flex justify-content-end container">
                    <div class="dropdown">
                        <button class="btn btn-sm drop-icons" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                          <li><a class="dropdown-item" href="#">Action</a></li>
                          <li><a class="dropdown-item" href="#">Another action</a></li>
                          <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-sm drop-icons rounded-circle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                          <li><a class="dropdown-item {{ (request()->is('admin/dashboard')) ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard</a></li>

                          <li><a class="dropdown-item {{ (request()->is('admin/profile')) ? 'active' : '' }}" href="{{ route('admin.profile') }}">Profile</a></li>

                          <li><a class="dropdown-item {{ (request()->is('admin/log')) ? 'active' : '' }}" href="#">Activity Log</a></li>

                          <li><a class="dropdown-item" href="javascript:void(0)" onclick="event.preventDefault();document.getElementById('logout-form').submit()">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>

        <div class="w-100 d-flex">
            <div id="sidebar">
                <div class="flex-shrink-0 p-3" style="width: 240px;">
                    <ul class="list-unstyled ps-0">
                        <li class="mb-1">
                            <button class="btn btn-toggle align-items-center rounded" data-bs-toggle="collapse" data-bs-target="#home-collapse" aria-expanded="{{ (request()->is('admin/dashboard*')) ? 'true' : 'false' }}">
                                Dashboard
                            </button>
                            <div class="collapse {{ (request()->is('admin/dashboard*')) ? 'show' : '' }}" id="home-collapse">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                    <li><a href="{{ route('admin.dashboard') }}" class="link-dark rounded {{ (request()->is('admin/dashboard')) ? 'active' : '' }}">Overview</a></li>
                                    <li><a href="#" class="link-dark rounded">Updates</a></li>
                                    <li><a href="#" class="link-dark rounded">Reports</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="mb-1">
                            <button class="btn btn-toggle align-items-center rounded" data-bs-toggle="collapse" data-bs-target="#orders-collapse" aria-expanded="{{ (request()->is('admin/order*')) ? 'true' : 'false' }}">
                                Orders
                            </button>
                            <div class="collapse {{ (request()->is('admin/order*')) ? 'show' : '' }}" id="orders-collapse">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                    <li><a href="{{ route('admin.order.list.all') }}" class="link-dark rounded {{ (request()->is('admin/order')) ? 'active' : '' }}">All</a></li>
                                    <li><a href="#" class="link-dark rounded">New</a></li>
                                    <li><a href="#" class="link-dark rounded">Processed</a></li>
                                    <li><a href="#" class="link-dark rounded">Shipped</a></li>
                                    <li><a href="#" class="link-dark rounded">Returned</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="mb-1">
                            <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#users-collapse" aria-expanded="{{ (request()->is('admin/users*')) ? 'true' : 'false' }}">
                                Users
                            </button>
                            <div class="collapse {{ (request()->is('admin/users*')) ? 'show' : '' }}" id="users-collapse">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                    <li><a href="{{ route('admin.users.list.all') }}" class="link-dark rounded {{ (request()->is('admin/users')) ? 'active' : '' }}">All</a></li>
                                    {{-- <li><a href="#" class="link-dark rounded">Processed</a></li>
                                    <li><a href="#" class="link-dark rounded">Shipped</a></li>
                                    <li><a href="#" class="link-dark rounded">Returned</a></li> --}}
                                </ul>
                            </div>
                        </li>
                        <li class="border-top my-3"></li>
                        <li class="mb-1">
                            <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#account-collapse" aria-expanded="false">
                            Account
                            </button>
                            <div class="collapse" id="account-collapse">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                    <li><a href="#" class="link-dark rounded">New...</a></li>
                                    <li><a href="#" class="link-dark rounded">Profile</a></li>
                                    <li><a href="#" class="link-dark rounded">Settings</a></li>
                                    <li><a href="#" class="link-dark rounded">Sign out</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="container bg-light-100 h-100 pt-2 pb-5" id="admin-content">
                <div class="card card-body">
                    <h5 class="card-title">@yield('page-title')</h5><hr>
                    @endif

                    @yield('section')

                    @if(!request()->is('admin/login'))
                </div>
            </div>
        </div>
    </section>
    @endif

    <form action="{{ route('admin.logout') }}" id="logout-form" method="post" class="d-none">@csrf</form>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('./js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('./js/common.js') }}"></script>
    <script src="{{ asset('./js/admin.js') }}"></script>

    <script>
        @if(Session::get('success'))
            toastFire('success', '{{Session::get("success")}}');
        @endif

        @if(Session::get('failure'))
            toastFire('error', '{{Session::get("failure")}}');
        @endif
    </script>

</body>
</html>