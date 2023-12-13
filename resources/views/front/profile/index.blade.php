@extends('front.layout.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-9">
        <section id="my-profile">
            <div class="row mb-4">
                <div class="col-12">
                    <div class="page-head">
                        <div class="profile-picture me-3">
                            <img src="{{ asset('uploads/static-front-missing-image/default-user.png') }}" alt="">
                        </div>
                        @if (!empty(auth()->guard('web')->user()->first_name))
                            <div class="text">
                                <h5>Welcome !</h5>
                                <p>{{ auth()->guard('web')->user()->first_name }}</p>
                            </div>
                        @else
                            <div class="text">
                                <h5 class="mt-3">Welcome !</h5>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            @if (
                empty(auth()->guard('web')->user()->first_name)
                || empty(auth()->guard('web')->user()->last_name)
                || empty(auth()->guard('web')->user()->email)
            )
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <h6>
                                Please tell us more about yourself. 
                                <a class="font-size-inherit" href="{{ route('front.user.profile.index', 'edit=true') }}">Edit details</a>
                            </h6>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col-md-3 profile-card">
                    <a href="{{ route('front.user.profile.index') }}">
                        <div class="card">
                            <div class="card-body">
                                <h5>My Profile</h5>
                                <p class="text-muted">Edit profile details & change password</p>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-3 profile-card">
                    <a href="{{ route('front.user.order.index') }}">
                        <div class="card">
                            <div class="card-body">
                                <h5>My Orders</h5>
                                <p class="text-muted">Track or view your current or previous orders</p>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-3 profile-card">
                    <a href="{{ route('front.user.address.index') }}">
                        <div class="card">
                            <div class="card-body">
                                <h5>Address</h5>
                                <p class="text-muted">Manage address for a faster checkout</p>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-3 profile-card">
                    <a href="{{ route('front.user.wishlist.index') }}">
                        <div class="card">
                            <div class="card-body">
                                <h5>Wishlist</h5>
                                <p class="text-muted">View or wishlist products to buy later </p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

        </section>
    </div>
</div>
@endsection
