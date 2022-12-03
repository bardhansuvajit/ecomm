@extends('front.layout.app')

@section('page-title', 'password update')

@section('section')
<section id="userProfileView">
    <div class="row">
        <div class="col-12">
            <h5 class="display-6 mb-4">
                <a href="{{ route('front.user.profile.edit') }}" class="back-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg>
                </a>
                Password
            </h5>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 mb-3">
            <div class="card">
                <div class="card-body text-center pt-4">
                    <img src="{{ asset('images/profile-picture/default.png') }}" alt="user" class="profile-picture">
                    <p class="text-muted fw-600">Login information</p>
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
                            <p class="text-muted fw-600 mb-0">Old password</p>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="to-show">
                                <div class="form-floating">
                                    <input type="password" class="form-control form-control-sm @error('old_password') is-invalid @enderror" id="old_password" placeholder="Old password" name="old_password" value="{{ old('old_password') ? old('old_password') : auth()->guard('web')->user()->old_password }}" autocomplete="first-name" maxlength="30">
                                    <label for="old_password">Old password *</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row row-container">
                        <div class="col-12 col-md-4 text-start text-md-end title">
                            <p class="text-muted fw-600 mb-0">New password</p>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="to-show">
                                <div class="form-floating">
                                    <input type="password" class="form-control form-control-sm @error('old_password') is-invalid @enderror" id="old_password" placeholder="New password" name="old_password" value="{{ old('old_password') ? old('old_password') : auth()->guard('web')->user()->old_password }}" autocomplete="first-name" maxlength="30">
                                    <label for="old_password">New password *</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row row-container">
                        <div class="col-12 col-md-4 text-start text-md-end title">
                            <p class="text-muted fw-600 mb-0">Confirm password</p>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="to-show">
                                <div class="form-floating">
                                    <input type="password" class="form-control form-control-sm @error('old_password') is-invalid @enderror" id="old_password" placeholder="Confirm password" name="old_password" value="{{ old('old_password') ? old('old_password') : auth()->guard('web')->user()->old_password }}" autocomplete="first-name" maxlength="30">
                                    <label for="old_password">Confirm password *</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row row-container">
                        <div class="col-md-4"></div>
                        <div class="col-12 col-md-6">
                            <div class="to-show">
                                <button class="btn btn-sm btn-primary save">Save</button>
                                <a href="{{ route('front.user.profile') }}" class="btn btn-sm btn-secondary cancel">Back to Profile</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
    <script>

    </script>
@endsection