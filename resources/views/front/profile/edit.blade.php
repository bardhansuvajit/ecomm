@extends('front.layout.app')

@section('page-title', 'edit profile')

@section('section')
<section id="userProfileView">
    <div class="row">
        <div class="col-12">
            <h5 class="display-6 mb-4">
                <a href="{{ route('front.user.profile') }}" class="back-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg>
                </a>
                My Profile
            </h5>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 mb-3">
            <div class="card">
                <div class="card-body text-center pt-4">
                    <img src="{{ asset('images/profile-picture/default.png') }}" alt="user" class="profile-picture">
                    <p class="text-muted fw-600">PROFILE IMAGE</p>
                    <p class="small text-muted mt-4">Your account details is completely safe with us. We do not share your account information with anyone.</p>
                </div>
                <div class="card-footer">
                    <p class="small text-muted mb-1">Account created {{ auth()->guard('web')->user()->created_at->diffForHumans() }}</p>
                    <p class="small text-muted mb-1">Last updated {{ auth()->guard('web')->user()->updated_at->diffForHumans() }}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card edit-card">
                <div class="card-body pt-0">

                    <div class="row row-container">
                        <div class="col-12 col-md-4 text-start text-md-end title">
                            <p class="text-muted fw-600 mb-0">NAME</p>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="to-show">
                                <p class="text-muted mb-0">{{ auth()->guard('web')->user()->first_name.' '.auth()->guard('web')->user()->last_name }}</p>
                            </div>
                            <div class="to-edit">
                                <div class="row g-3">
                                    <div class="col-6 mt-0">
                                        <div class="form-floating">
                                            <input type="text" class="form-control form-control-sm @error('first_name') is-invalid @enderror" id="first_name" placeholder="First name" name="first_name" value="{{ old('first_name') ? old('first_name') : auth()->guard('web')->user()->first_name }}" autocomplete="first-name" maxlength="30" form="profile-edit">
                                            <label for="first_name">First name *</label>
                                        </div>
                                    </div>
                                    <div class="col-6 mt-0">
                                        <div class="form-floating">
                                            <input type="text" class="form-control form-control-sm @error('last_name') is-invalid @enderror" id="last_name" placeholder="Last name" name="last_name" value="{{ old('last_name') ? old('last_name') : auth()->guard('web')->user()->last_name }}" autocomplete="last-name" maxlength="30" form="profile-edit">
                                            <label for="last_name">Last name *</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row row-container">
                        <div class="col-12 col-md-4 text-start text-md-end title">
                            <p class="text-muted fw-600 mb-0">GENDER</p>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="to-show">
                                <p class="text-muted mb-0">{{ ucwords(auth()->guard('web')->user()->gender) }}</p>
                            </div>
                            <div class="to-edit">
                                <div class="btn-group">
                                    <input type="radio" name="gender" class="btn-check" id="gender-female" form="profile-edit" value="female" {{ (auth()->guard('web')->user()->gender == 'female') ? 'checked' : '' }}>
                                    <label for="gender-female" class="btn btn-sm btn-outline-secondary">Female</label>

                                    <input type="radio" name="gender" class="btn-check" id="gender-male" form="profile-edit" value="male" {{ (auth()->guard('web')->user()->gender == 'male') ? 'checked' : '' }}>
                                    <label for="gender-male" class="btn btn-sm btn-outline-secondary">Male</label>

                                    <input type="radio" name="gender" class="btn-check" id="gender-other" form="profile-edit" value="other" {{ (auth()->guard('web')->user()->gender == 'other') ? 'checked' : '' }}>
                                    <label for="gender-other" class="btn btn-sm btn-outline-secondary">Other</label>

                                    <input type="radio" name="gender" class="btn-check" id="gender-not-specified" form="profile-edit" value="not specified" {{ (auth()->guard('web')->user()->gender == 'not specified') ? 'checked' : '' }}>
                                    <label for="gender-not-specified" class="btn btn-sm btn-outline-secondary">Not specified</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row row-container">
                        <div class="col-12 col-md-4 text-start text-md-end title">
                            <p class="text-muted fw-600 mb-0">MOBILE NUMBER</p>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="to-show">
                                <p class="text-muted mb-0">{{ auth()->guard('web')->user()->mobile_no }}</p>
                            </div>
                            <div class="to-edit">
                                <div class="form-floating">
                                    <input type="number" class="form-control form-control-sm @error('mobile_no') is-invalid @enderror" id="mobile_no" placeholder="Mobile number" name="mobile_no" value="{{ old('mobile_no') ? old('mobile_no') : auth()->guard('web')->user()->mobile_no }}" autocomplete="tel" maxlength="30" form="profile-edit">
                                    <label for="mobile_no">Mobile number *</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row row-container">
                        <div class="col-12 col-md-4 text-start text-md-end title">
                            <p class="text-muted fw-600 mb-0">Email</p>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="to-show">
                                <p class="text-muted mb-0">{{ auth()->guard('web')->user()->email }}</p>
                            </div>
                            <div class="to-edit">
                                <div class="form-floating">
                                    <input type="email" class="form-control form-control-sm @error('email') is-invalid @enderror" id="email" placeholder="Email" name="email" value="{{ old('email') ? old('email') : auth()->guard('web')->user()->email }}" autocomplete="email" maxlength="100" form="profile-edit">
                                    <label for="email">Email *</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row row-container">
                        <div class="col-12 col-md-4 text-start text-md-end title">
                            <p class="text-muted fw-600 mb-0">Password</p>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="to-show">
                                <p class="text-muted mb-0" style="line-height: 13px;">*********</p>
                                <p class="small text-muted mb-0">Keep changing you password frequently</p>
                            </div>
                            <div class="to-edit">
                                <a href="{{ route('front.user.password.edit') }}" class="btn btn-secondary">Change Password</a>
                            </div>
                        </div>
                    </div>

                    <div class="row row-container">
                        <div class="col-md-4"></div>
                        <div class="col-12 col-md-6">
                            <div class="to-show">
                                <button class="btn btn-sm btn-primary edit">Tap to Edit</button>
                            </div>
                            <div class="to-edit">
                                <form action="{{ route('front.user.profile.update') }}" method="post" class="d-inline" id="profile-edit">@csrf
                                    <button type="submit" class="btn btn-sm btn-primary save">Save</button>
                                </form>
                                <button class="btn btn-sm btn-secondary cancel">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    {{-- <div class="row">
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
                    <a href="">
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
            <a href="">
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
            <a href="">
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
            <a href="">
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
    </div> --}}
</section>
@endsection

@section('script')
    <script>
        $('#userProfileView .edit-card .edit').on('click', () => {
            $('.to-show').hide();
            $('.to-edit').addClass('d-inline-block');
        });

        $('#userProfileView .edit-card .cancel').on('click', () => {
            $('.to-show').show();
            $('.to-edit').removeClass('d-inline-block');
        });

        if (window.location.href.indexOf("error=true") != -1) {
            $('.to-show').hide();
            $('.to-edit').addClass('d-inline-block');
        }
    </script>
@endsection