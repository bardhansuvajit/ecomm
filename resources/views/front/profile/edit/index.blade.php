@extends('front.layout.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-9">
        <section id="my-profile">
            <div class="row mb-5">
                <div class="col-12">
                    <div class="page-head">
                        <div class="redirect me-3">
                            {{-- <a href="javascript: void(0)" onclick="history.back(-1)"> --}}
                            <a href="{{ route('front.user.account') }}">
                                <i class="material-icons">keyboard_arrow_left</i>
                            </a>
                        </div>
                        <div class="text">
                            <h5>My profile</h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="profile-edit-content">
                @if (
                    empty(auth()->guard('web')->user()->first_name)
                    || empty(auth()->guard('web')->user()->last_name)
                    || empty(auth()->guard('web')->user()->email)
                )
                    @if (!request()->input('edit') == 'true')
                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <h6>
                                        Please tell us more about yourself. 
                                        <a class="font-size-inherit" href="javascript: void(0)" onclick="editProfile()">Edit details</a>
                                    </h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif

                <form action="{{ route('front.user.profile.edit') }}" method="post">@csrf
                    <div class="row">
                        <div class="col-md-4 text-end">
                            <h6 class="text-muted-light margin-11">NAME *</h6>
                        </div>
                        <div class="col-md-8">
                            <div class="profile_default margin-11">
                                <h6 class="text-dark">
                                    {{ auth()->guard('web')->user()->first_name }} 
                                    {{ auth()->guard('web')->user()->last_name }}
                                </h6>
                            </div>

                            <div class="profile_edit">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control form-control-sm" placeholder="First name" name="first_name" value="{{ old('first_name') ? old('first_name') : auth()->guard('web')->user()->first_name }}">

                                        @error ('first_name') <p class="text-danger">{{$message}}</p> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control form-control-sm" placeholder="Last name" name="last_name" value="{{ old('last_name') ? old('last_name') : auth()->guard('web')->user()->last_name }}">

                                        @error ('last_name') <p class="text-danger">{{$message}}</p> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-4 text-end">
                            <h6 class="text-muted-light margin-11">GENDER</h6>
                        </div>
                        <div class="col-md-8">
                            <div class="profile_default margin-11">
                                <h6 class="text-dark">{{ (auth()->guard('web')->user()->gender != 'not specified') ? strtoupper(auth()->guard('web')->user()->gender) : '' }}</h6>
                            </div>

                            <div class="profile_edit">
                                <div class="btn-group mt-2">
                                    <input type="radio" name="gender" id="gender-male" class="btn-check" value="male" {{ old('gender') ? ( (old('gender') == 'male') ? 'checked' : '' ) : ( (auth()->guard('web')->user()->gender == 'male') ? 'checked' : '' ) }}>
                                    <label class="btn btn-sm btn-outline-dark rounded-0" for="gender-male">Male</label>

                                    <input type="radio" name="gender" id="gender-demale" class="btn-check" value="female" {{ old('gender') ? ( (old('gender') == 'female') ? 'checked' : '' ) : ( (auth()->guard('web')->user()->gender == 'female') ? 'checked' : '' ) }}>
                                    <label class="btn btn-sm btn-outline-dark rounded-0" for="gender-demale">Female</label>
                                </div>

                                @error ('gender') <p class="text-danger">{{$message}}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-4 text-end">
                            <h6 class="text-muted-light margin-11">MOBILE NUMBER *</h6>
                        </div>
                        <div class="col-md-8">
                            <div class="profile_default margin-11">
                                <h6 class="text-dark">{{ auth()->guard('web')->user()->mobile_no }}</h6>
                            </div>

                            <div class="profile_edit">
                                <input type="number" class="form-control form-control-sm me-3" placeholder="Mobile number" name="mobile_no" value="{{ old('mobile_no') ? old('mobile_no') : auth()->guard('web')->user()->mobile_no }}" onkeypress="return isNumeric(event)" oninput="maxLengthCheck(this)" maxlength="10">

                                @error ('mobile_no') <p class="text-danger">{{$message}}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-4 text-end">
                            <h6 class="text-muted-light margin-11">EMAIL ADDRESS *</h6>
                        </div>
                        <div class="col-md-8">
                            <div class="profile_default margin-11">
                                <h6 class="text-dark">{{ auth()->guard('web')->user()->email }}</h6>
                            </div>

                            <div class="profile_edit">
                                <input type="text" class="form-control form-control-sm me-3" placeholder="Email Address" name="email" value="{{ old('email') ? old('email') : auth()->guard('web')->user()->email }}">

                                @error ('email') <p class="text-danger">{{$message}}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-4 text-end">
                            <h6 class="text-muted-light margin-11">PASSWORD</h6>
                        </div>
                        <div class="col-md-8">
                            <div class="profile_default margin-11">
                                <h6 class="text-muted-light">*****</h6>
                            </div>

                            <div class="profile_edit">
                                <a href="{{ route('front.user.password.edit') }}" class="btn btn-primary btn-sm rounded-0 mt-2">Change Password</a>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-4">
                        </div>
                        <div class="col-8">
                            <div class="profile_default">
                                <button type="button" class="btn btn-sm btn-dark rounded-0" onclick="editProfile()">Tap to edit</button>
                            </div>
                            <div class="profile_edit">
                                <button type="submit" class="btn btn-sm btn-dark rounded-0">Save details</button>
                                <button type="button" class="btn btn-sm btn-light rounded-0" onclick="cancelEditProfile()">Cancel</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>
@endsection

@section('script')
    <script>
        @if (request()->input('error') == 'true' || request()->input('edit') == 'true')
            editProfile();
        @endif
    </script>
@endsection