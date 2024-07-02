@extends('admin.layout.app')
@section('page-title', 'Profile')

@section('section')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">

                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            @if (!empty(auth()->guard('admin')->user()->image_small) && file_exists(auth()->guard('admin')->user()->image_small))
                                <img src="{{ asset(auth()->guard('admin')->user()->image_small) }}" class="profile-user-img img-fluid img-circle" alt="Image">
                            @else
                                <img src="{{ asset('backend-assets/images/user2-160x160.jpg') }}" class="profile-user-img img-fluid img-circle" alt="Image">
                            @endif
                        </div>

                        <h3 class="profile-username text-center">{{ auth()->guard('admin')->user()->name }}</h3>

                        <p class="text-muted text-center">{{ auth()->guard('admin')->user()->designation }}</p>
                        <p class="text-muted text-center" style="overflow: hidden;display: -webkit-box;-webkit-line-clamp: 2;line-clamp: 2; -webkit-box-orient: vertical;">{{ auth()->guard('admin')->user()->bio }}</p>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Email id</b> <a class="float-right">{{ auth()->guard('admin')->user()->email }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Mobile</b> <a class="float-right">{{ auth()->guard('admin')->user()->mobile_no }}</a>
                            </li>
                        </ul>

                        <a href="{{ route('admin.profile.index') }}" class="btn btn-primary btn-block"><b> <i class="fas fa-user"></i> Edit profile</b></a>
                    </div>
                </div>

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">About Me</h3>
                    </div>
                    <div class="card-body">
                        <strong><i class="fas fa-book mr-1"></i> Bio</strong>
                        <p class="text-muted">{{ auth()->guard('admin')->user()->bio }}</p>
                        <hr>

                        <strong><i class="fas fa-book mr-1"></i> Company</strong>
                        <p class="text-muted">{{ auth()->guard('admin')->user()->company }}</p>
                        <hr>

                        <strong><i class="fas fa-book mr-1"></i> Designation</strong>
                        <p class="text-muted">{{ auth()->guard('admin')->user()->designation }}</p>
                        <hr>

                        <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>
                        <p class="text-muted">{{ auth()->guard('admin')->user()->location_info }}</p>
                        <hr>

                        <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>
                        <p class="text-muted">{{ auth()->guard('admin')->user()->skills }}</p>
                        <hr>

                        <strong><i class="fas fa-file-alt mr-1"></i> Experience</strong>
                        <p class="text-muted">{{ auth()->guard('admin')->user()->experience }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.profile.index') }}">Edit profile</a></li>
                            <li class="nav-item"><a class="nav-link active" href="#settings" data-bs-toggle="tab">Change password</a></li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="settings">
                                <form class="form-horizontal" method="post" action="{{ route('admin.profile.password.update') }}">@csrf
                                    <div class="form-group row">
                                        <label for="old_password" class="col-sm-2 col-form-label">Current <span class="text-muted">*</span> </label>
                                        <div class="col-sm-10">
                                            <input type="password" class="form-control" id="old_password" placeholder="Enter current password" name="old_password" value="">
                                            @error('old_password') <p class="small text-danger">{{ $message }}</p> @enderror
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="form-group row">
                                        <label for="new_password" class="col-sm-2 col-form-label">New <span class="text-muted">*</span> </label>
                                        <div class="col-sm-10">
                                            <input type="password" class="form-control" id="new_password" placeholder="Enter new password" name="new_password" value="">
                                            @error('new_password') <p class="small text-danger">{{ $message }}</p> @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="confirm_password" class="col-sm-2 col-form-label">Confirm <span class="text-muted">*</span> </label>
                                        <div class="col-sm-10">
                                            <input type="password" class="form-control" id="confirm_password" placeholder="Re-enter new password" name="confirm_password" value="">
                                            @error('confirm_password') <p class="small text-danger">{{ $message }}</p> @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            <button type="submit" class="btn btn-success">Save changes</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection