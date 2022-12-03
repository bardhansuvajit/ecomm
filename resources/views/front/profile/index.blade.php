@extends('front.layout.app')

@section('page-title', 'profile')

@section('section')
<section id="userProfile">
    <div class="row">
        <div class="col-12 col-md-6">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <img src="{{ asset('images/profile-picture/default.png') }}" alt="user" class="profile-picture">
                </div>
                <div class="flex-grow-1 ms-3">
                    <p class="small text-muted mb-2">Hi,</p>
                    <h5 class="small fw-600">Suvajit</h5>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 mt-4 mt-md-3">
            <div class="row justify-content-end">
                <div class="col-6 col-md-auto">
                    <a href="">
                        <div class="wallet">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-gift"><polyline points="20 12 20 22 4 22 4 12"></polyline><rect x="2" y="7" width="20" height="5"></rect><line x1="12" y1="22" x2="12" y2="7"></line><path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"></path><path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"></path></svg>
                            <span class="amount">&#8377;0.00</span>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-md-auto">
                    <a href="{{ route('front.user.wishlist') }}">
                        <div class="wishlist justify-content-end">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="tomato" stroke="tomato" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                            <span class="title">Wishlist</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4 mt-md-5">
        <div class="col-6 col-md-4 mb-3">
            <a href="{{ route('front.user.profile.edit') }}">
                <div class="card card-body main-profile-card">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 me-3">
                            <h5 class="card-title">My Profile</h5>
                            <p class="small text-muted mb-2">Edit profile details, change password</p>
                        </div>
                        <div class="flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-4 mb-3">
            <a href="{{ route('front.user.order') }}">
                <div class="card card-body main-profile-card">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 me-3">
                            <h5 class="card-title">My Orders</h5>
                            <p class="small text-muted mb-2">View your order details</p>
                        </div>
                        <div class="flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-4 mb-3">
            <a href="{{ route('front.user.address') }}">
                <div class="card card-body main-profile-card">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 me-3">
                            <h5 class="card-title">Address</h5>
                            <p class="small text-muted mb-2">Manage address for a faster checkout</p>
                        </div>
                        <div class="flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map-pin"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</section>
@endsection