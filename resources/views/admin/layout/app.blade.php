<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="{{ asset($officeInfo->favicon) }}" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $officeInfo->pretty_name }} - @yield('page-title')</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('backend-assets/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend-assets/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend-assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend-assets/css/style.css') }}">

    @yield('style')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ url('/') }}" class="nav-link" target="_blank">Website</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">Dashboard</a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                {{-- <li class="nav-item">
                    <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                    <i class="fas fa-search"></i>
                    </a>
                    <div class="navbar-search-block">
                    <form class="form-inline">
                        <div class="input-group input-group-sm">
                        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-navbar" type="submit">
                            <i class="fas fa-search"></i>
                            </button>
                            <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                            <i class="fas fa-times"></i>
                            </button>
                        </div>
                        </div>
                    </form>
                    </div>
                </li> --}}

                {{-- <li class="nav-item dropdown">
                    <a class="nav-link" data-bs-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-warning navbar-badge">15</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-header">15 Notifications</span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-envelope mr-2"></i> 4 new messages
                        <span class="float-right text-muted text-sm">3 mins</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-users mr-2"></i> 8 friend requests
                        <span class="float-right text-muted text-sm">12 hours</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-file mr-2"></i> 3 new reports
                        <span class="float-right text-muted text-sm">2 days</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                    </div>
                </li> --}}
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                    <i class="fas fa-th-large"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">
                            <i class="fas fa-user"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="{{ route('admin.profile.index') }}" class="dropdown-item">
                                <div class="media">
                                    @if (!empty(auth()->guard('admin')->user()->image_small) && file_exists(auth()->guard('admin')->user()->image_small))
                                        <img src="{{ asset(auth()->guard('admin')->user()->image_small) }}" class="img-size-50 mr-3 img-circle mt-3" alt="Image">
                                    @else
                                        <img src="{{ asset('backend-assets/images/user2-160x160.jpg') }}" class="img-size-50 mr-3 img-circle mt-3">
                                    @endif

                                    <div class="media-body">
                                        <h3 class="dropdown-item-title">
                                            {{ auth()->guard('admin')->user()->name }}
                                        </h3>
                                        <p class="text-sm">{{ auth()->guard('admin')->user()->username }}</p>
                                        <p class="small text-muted" title="Last profile updated"><i class="far fa-clock mr-1"></i> {{ h_date(auth()->guard('admin')->user()->updated_at) }}</p>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item dropdown-footer text-danger font-weight-bold text-end" href="javascript:void(0)" onclick="event.preventDefault();document.getElementById('logout-form').submit()">Logout</a>
                        </div>
                    </div>
                </li>
            </ul>
        </nav>

        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="{{ url('/') }}" class="brand-link text-center" target="_blank">
                @if (!empty($officeInfo->primary_logo) && file_exists($officeInfo->primary_logo))
                    <img src="{{ asset($officeInfo->primary_logo) }}" alt="site-logo" class="" style="height: 43px;opacity: .8">
                @else
                    <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" style="height: 43px; width: 200px">
                @endif
            </a>

            <div class="sidebar">
                <div class="user-panel mt-2 pb-2 d-flex">
                    <div class="image">
                        @if (!empty(auth()->guard('admin')->user()->image_small) && file_exists(auth()->guard('admin')->user()->image_small))
                            <img src="{{ asset(auth()->guard('admin')->user()->image_small) }}" class="img-circle elevation-2" alt="user">
                        @else
                            <img src="{{ asset('backend-assets/images/user2-160x160.jpg') }}" class="rounded-circle" style="height: 30px;width: 30px">
                        @endif
                    </div>
                    <div class="info">
                        <a href="{{ route('admin.profile.index') }}" class="d-block">{{ auth()->guard('admin')->user()->name }}</a>
                    </div>
                </div>

                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ (request()->is('admin/dashboard')) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.order.list.all') }}" class="nav-link {{ (request()->is('admin/order*')) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-shopping-bag"></i>
                                <p>Order</p>
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a href="{{ route('admin.category.list.all') }}" class="nav-link {{ (request()->is('admin/category*')) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-list-alt"></i>
                                <p>Category</p>
                            </a>
                        </li> --}}
                        <li class="nav-item {{ (request()->is('admin/product*')) ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ (request()->is('admin/product*')) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-shopping-cart"></i>
                                <p>Product <i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.product.list.all') }}" class="nav-link {{ (request()->is('admin/product/list*')) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>List</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.product.setup.category') }}" class="nav-link {{ (request()->is('admin/product/setup*')) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Create</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.product.feature.all') }}" class="nav-link {{ (request()->is('admin/product/feature*')) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Feature</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.product.collection.list.all') }}" class="nav-link {{ (request()->is('admin/product/collection*')) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Collection</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.product.category.list.all', 1) }}" class="nav-link {{ (request()->is('admin/product/category/1*')) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Category 1</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.product.category.list.all', 2) }}" class="nav-link {{ (request()->is('admin/product/category/2*')) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Category 2</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.product.category.list.all', 3) }}" class="nav-link {{ (request()->is('admin/product/category/3*')) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Category 3</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.product.category.list.all', 4) }}" class="nav-link {{ (request()->is('admin/product/category/4*')) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Category 4</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.product.variation.list') }}" class="nav-link {{ (request()->is('admin/product/variation*')) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Variation</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.product.variation.option.list') }}" class="nav-link {{ (request()->is('admin/product/variation/option*')) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Variation option</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        {{-- <li class="nav-item">
                            <a href="{{ route('admin.product.list.all') }}" class="nav-link {{ (request()->is('admin/product*')) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-shopping-cart"></i>
                                <p>Product</p>
                            </a>
                        </li> --}}
                        <li class="nav-item">
                            <a href="{{ route('admin.review.list.all') }}" class="nav-link {{ (request()->is('admin/review*')) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-star"></i>
                                <p>Review</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.user.list.all') }}" class="nav-link {{ (request()->is('admin/user*')) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user"></i>
                                <p>Users</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.coupon.list.all') }}" class="nav-link {{ (request()->is('admin/coupon*')) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-gift"></i>
                                <p>Coupon</p>
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a href="{{ route('admin.blog.list.all') }}" class="nav-link {{ (request()->is('admin/blog*')) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-list-alt"></i>
                                <p>Blog</p>
                            </a>
                        </li> --}}
                        <li class="nav-item {{ (request()->is('admin/blog*')) ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ (request()->is('admin/blog*')) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-book"></i>
                                <p>Blog <i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.blog.list.all') }}" class="nav-link {{ (request()->is('admin/blog/list*')) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Blog</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.blog.feature.all') }}" class="nav-link {{ (request()->is('admin/blog/feature*')) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Feature</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.blog.category1.list.all') }}" class="nav-link {{ (request()->is('admin/blog/category1*')) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Category 1</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.blog.category2.list.all') }}" class="nav-link {{ (request()->is('admin/blog/category2*')) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Category 2</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.blog.tag.list.all') }}" class="nav-link {{ (request()->is('admin/blog/tag*')) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Tag</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.lead.list.all') }}" class="nav-link {{ (request()->is('admin/lead*')) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Leads</p>
                            </a>
                        </li>
                        <li class="nav-item {{ (request()->is('admin/content*')) ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ (request()->is('admin/content*')) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-file-alt"></i>
                                <p>Page content <i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.content.seo.list.all') }}" class="nav-link {{ (request()->is('admin/content/seo*')) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>SEO</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.content.banner.list.all') }}" class="nav-link {{ (request()->is('admin/content/banner*')) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Banner</p>
                                    </a>
                                </li>
                                @foreach ($contentPages as $page)
                                    <li class="nav-item">
                                        <a href="{{ route('admin.content.edit', $page->page) }}" class="nav-link {{ (request()->is('admin/content/page/'.$page->page.'*')) ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>{!! $page->title !!}</p>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="nav-item {{ (request()->is('admin/management*')) ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ (request()->is('admin/management*')) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-check"></i>
                                <p>Management <i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.management.notice.list.all') }}" class="nav-link {{ (request()->is('admin/management/notice*')) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Notice</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.management.partner.list.all') }}" class="nav-link {{ (request()->is('admin/management/partner*')) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Partner</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.management.testimonial.list.all') }}" class="nav-link {{ (request()->is('admin/management/testimonial*')) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Testimonial</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link {{ (request()->is('admin/content/security*')) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Event</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link {{ (request()->is('admin/content/security*')) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Service</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link {{ (request()->is('admin/content/security*')) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Portfolio</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link {{ (request()->is('admin/content/security*')) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Gallery</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.management.socialmedia.list.all') }}" class="nav-link {{ (request()->is('admin/management/socialmedia*')) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Social Media</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.management.instagram.post.list.all') }}" class="nav-link {{ (request()->is('admin/management/instagram*')) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Instagram post</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item {{ (request()->is('admin/office*')) ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ (request()->is('admin/office*')) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-building"></i>
                                <p>Application <i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.office.information.detail') }}" class="nav-link {{ (request()->is('admin/office/information*')) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Information</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.office.address.list.all') }}" class="nav-link {{ (request()->is('admin/office/address*')) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Address</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.office.email.list.all') }}" class="nav-link {{ (request()->is('admin/office/email*')) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Email ID</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.office.phone.list.all') }}" class="nav-link {{ (request()->is('admin/office/phone*')) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Phone number</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.profile.index') }}" class="nav-link {{ (request()->is('admin/profile*')) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user"></i>
                                <p>Profile</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0)" onclick="event.preventDefault();document.getElementById('logout-form').submit()">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>Logout</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.database.reset.index') }}" class="nav-link {{ (request()->is('admin/database*')) ? 'active' : '' }}" onclick="return confirm('Are you sure ?')">
                                <i class="nav-icon fas fa-ban text-danger"></i>
                                <p>Reset DB</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">@yield('page-title')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">@yield('page-title')</li>
                        </ol>
                    </div>
                    </div>
                </div>
            </div>

            @yield('section')

        </div>

        <aside class="control-sidebar control-sidebar-dark">
            <div class="p-3">
                <h5>Quick access</h5>
                <p>Sidebar content</p>
            </div>
        </aside>

        <footer class="main-footer">
            <div class="float-right d-none d-sm-inline">
                &copy; {{ $officeInfo->full_name }} All rights reserved
            </div>
            <strong>{{ date('Y') }} - <a href="{{ url('/') }}" target="_blank">{{ $officeInfo->full_name }}</a></strong>
        </footer>
    </div>

    <form action="{{ route('admin.logout') }}" id="logout-form" method="post" class="d-none">@csrf</form>

    <script src="{{ asset('backend-assets/plugins/jquery/jquery.min.js') }}"></script>
    {{-- <script src="{{ asset('backend-assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script> --}}
    <script src="{{ asset('backend-assets/js/adminlte.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="{{ asset('backend-assets/js/bootstrap.min.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js" integrity="sha256-eTyxS0rkjpLEo16uXTS0uVCS4815lc40K2iVpWDvdSY=" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('backend-assets/js/custom.js') }}"></script>

    <script>
        @if(Session::get('success'))
            toastFire('success', '{{Session::get("success")}}');
        @endif

        @if(Session::get('failure'))
            toastFire('error', '{{Session::get("failure")}}');
        @endif
    </script>

    @yield('script')
</body>
</html>