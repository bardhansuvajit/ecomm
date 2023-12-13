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
                            <img src="{{ asset(auth()->guard('admin')->user()->image_small) }}" class="profile-user-img img-fluid img-circle" alt="Image">
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

                        <a href="{{ route('admin.profile.password.index') }}" class="btn btn-primary btn-block"><b> <i class="fas fa-lock"></i> Change password</b></a>
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
                            {{-- <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Activity</a></li>
                            <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Timeline</a></li> --}}
                            <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Edit profile</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.profile.password.index') }}">Change password</a></li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            {{-- <div class="tab-pane" id="activity">
                                <div class="post">
                                    <div class="user-block">
                                    <img class="img-circle img-bordered-sm" src="../../dist/img/user1-128x128.jpg" alt="user image">
                                    <span class="username">
                                        <a href="#">Jonathan Burke Jr.</a>
                                        <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                                    </span>
                                    <span class="description">Shared publicly - 7:30 PM today</span>
                                    </div>
                                    <!-- /.user-block -->
                                    <p>
                                    Lorem ipsum represents a long-held tradition for designers,
                                    typographers and the like. Some people hate it and argue for
                                    its demise, but others ignore the hate as they create awesome
                                    tools to help create filler text for everyone from bacon lovers
                                    to Charlie Sheen fans.
                                    </p>

                                    <p>
                                    <a href="#" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i> Share</a>
                                    <a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i> Like</a>
                                    <span class="float-right">
                                        <a href="#" class="link-black text-sm">
                                        <i class="far fa-comments mr-1"></i> Comments (5)
                                        </a>
                                    </span>
                                    </p>

                                    <input class="form-control form-control-sm" type="text" placeholder="Type a comment">
                                </div>
                                <div class="post clearfix">
                                    <div class="user-block">
                                    <img class="img-circle img-bordered-sm" src="../../dist/img/user7-128x128.jpg" alt="User Image">
                                    <span class="username">
                                        <a href="#">Sarah Ross</a>
                                        <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                                    </span>
                                    <span class="description">Sent you a message - 3 days ago</span>
                                    </div>
                                    <!-- /.user-block -->
                                    <p>
                                    Lorem ipsum represents a long-held tradition for designers,
                                    typographers and the like. Some people hate it and argue for
                                    its demise, but others ignore the hate as they create awesome
                                    tools to help create filler text for everyone from bacon lovers
                                    to Charlie Sheen fans.
                                    </p>

                                    <form class="form-horizontal">
                                    <div class="input-group input-group-sm mb-0">
                                        <input class="form-control form-control-sm" placeholder="Response">
                                        <div class="input-group-append">
                                        <button type="submit" class="btn btn-danger">Send</button>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                                <div class="post">
                                    <div class="user-block">
                                    <img class="img-circle img-bordered-sm" src="../../dist/img/user6-128x128.jpg" alt="User Image">
                                    <span class="username">
                                        <a href="#">Adam Jones</a>
                                        <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                                    </span>
                                    <span class="description">Posted 5 photos - 5 days ago</span>
                                    </div>
                                    <!-- /.user-block -->
                                    <div class="row mb-3">
                                    <div class="col-sm-6">
                                        <img class="img-fluid" src="../../dist/img/photo1.png" alt="Photo">
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-6">
                                        <div class="row">
                                        <div class="col-sm-6">
                                            <img class="img-fluid mb-3" src="../../dist/img/photo2.png" alt="Photo">
                                            <img class="img-fluid" src="../../dist/img/photo3.jpg" alt="Photo">
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-sm-6">
                                            <img class="img-fluid mb-3" src="../../dist/img/photo4.jpg" alt="Photo">
                                            <img class="img-fluid" src="../../dist/img/photo1.png" alt="Photo">
                                        </div>
                                        <!-- /.col -->
                                        </div>
                                        <!-- /.row -->
                                    </div>
                                    <!-- /.col -->
                                    </div>
                                    <!-- /.row -->

                                    <p>
                                    <a href="#" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i> Share</a>
                                    <a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i> Like</a>
                                    <span class="float-right">
                                        <a href="#" class="link-black text-sm">
                                        <i class="far fa-comments mr-1"></i> Comments (5)
                                        </a>
                                    </span>
                                    </p>

                                    <input class="form-control form-control-sm" type="text" placeholder="Type a comment">
                                </div>
                            </div>
                            <div class="tab-pane" id="timeline">
                                <div class="timeline timeline-inverse">
                                    <!-- timeline time label -->
                                    <div class="time-label">
                                    <span class="bg-danger">
                                        10 Feb. 2014
                                    </span>
                                    </div>
                                    <!-- /.timeline-label -->
                                    <!-- timeline item -->
                                    <div>
                                    <i class="fas fa-envelope bg-primary"></i>

                                    <div class="timeline-item">
                                        <span class="time"><i class="far fa-clock"></i> 12:05</span>

                                        <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

                                        <div class="timeline-body">
                                        Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                                        weebly ning heekya handango imeem plugg dopplr jibjab, movity
                                        jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                                        quora plaxo ideeli hulu weebly balihoo...
                                        </div>
                                        <div class="timeline-footer">
                                        <a href="#" class="btn btn-primary btn-sm">Read more</a>
                                        <a href="#" class="btn btn-danger btn-sm">Delete</a>
                                        </div>
                                    </div>
                                    </div>
                                    <!-- END timeline item -->
                                    <!-- timeline item -->
                                    <div>
                                    <i class="fas fa-user bg-info"></i>

                                    <div class="timeline-item">
                                        <span class="time"><i class="far fa-clock"></i> 5 mins ago</span>

                                        <h3 class="timeline-header border-0"><a href="#">Sarah Young</a> accepted your friend request
                                        </h3>
                                    </div>
                                    </div>
                                    <!-- END timeline item -->
                                    <!-- timeline item -->
                                    <div>
                                    <i class="fas fa-comments bg-warning"></i>

                                    <div class="timeline-item">
                                        <span class="time"><i class="far fa-clock"></i> 27 mins ago</span>

                                        <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>

                                        <div class="timeline-body">
                                        Take me to your leader!
                                        Switzerland is small and neutral!
                                        We are more like Germany, ambitious and misunderstood!
                                        </div>
                                        <div class="timeline-footer">
                                        <a href="#" class="btn btn-warning btn-flat btn-sm">View comment</a>
                                        </div>
                                    </div>
                                    </div>
                                    <!-- END timeline item -->
                                    <!-- timeline time label -->
                                    <div class="time-label">
                                    <span class="bg-success">
                                        3 Jan. 2014
                                    </span>
                                    </div>
                                    <!-- /.timeline-label -->
                                    <!-- timeline item -->
                                    <div>
                                    <i class="fas fa-camera bg-purple"></i>

                                    <div class="timeline-item">
                                        <span class="time"><i class="far fa-clock"></i> 2 days ago</span>

                                        <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>

                                        <div class="timeline-body">
                                        <img src="https://placehold.it/150x100" alt="...">
                                        <img src="https://placehold.it/150x100" alt="...">
                                        <img src="https://placehold.it/150x100" alt="...">
                                        <img src="https://placehold.it/150x100" alt="...">
                                        </div>
                                    </div>
                                    </div>
                                    <!-- END timeline item -->
                                    <div>
                                    <i class="far fa-clock bg-gray"></i>
                                    </div>
                                </div>
                            </div> --}}

                            <div class="tab-pane active" id="settings">
                                <form class="form-horizontal" method="post" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">@csrf
                                    <div class="form-group row">
                                        <label for="name" class="col-sm-2 col-form-label">Image </label>
                                        <div class="col-sm-10">
                                            <input type="file" name="image_small" id="image_small" class="form-control" accept=".jpg,.png,.jpeg">
                                            {!! imageUploadNotice('profile-image')['html'] !!}
                                            @error('image_small') <p class="small text-danger">{{ $message }}</p> @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="name" class="col-sm-2 col-form-label">Name <span class="text-muted">*</span> </label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="name" placeholder="Full name" name="name" value="{{ old('name') ? old('name') : auth()->guard('admin')->user()->name }}">
                                            @error('name') <p class="small text-danger">{{ $message }}</p> @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="email" class="col-sm-2 col-form-label">Email <span class="text-muted">*</span> </label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" id="email" placeholder="Email" name="email" value="{{ old('email') ? old('email') : auth()->guard('admin')->user()->email }}">

                                            @error('email') <p class="small text-danger">{{ $message }}</p> @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="mobile_no" class="col-sm-2 col-form-label">Mobile number</label>
                                        <div class="col-sm-10">
                                            <input type="number" class="form-control" id="mobile_no" placeholder="Mobile number" name="mobile_no" value="{{ old('mobile_no') ? old('mobile_no') : auth()->guard('admin')->user()->mobile_no }}">
                                            @error('mobile_no') <p class="small text-danger">{{ $message }}</p> @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="username" class="col-sm-2 col-form-label">Username</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="username" placeholder="Username" name="username" value="{{ old('username') ? old('username') : auth()->guard('admin')->user()->username }}" disabled>

                                            <p class="small text-muted mt-2 mb-2"> <i class="fas fa-info-circle"></i> Username is used for login purpose. Please contact developer support to edit this.</p>

                                            @error('username') <p class="small text-danger">{{ $message }}</p> @enderror
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="form-group row">
                                        <label for="bio" class="col-sm-2 col-form-label">Bio</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" id="bio" placeholder="Bio" name="bio" rows="4">{{ old('bio') ? old('bio') : auth()->guard('admin')->user()->bio }}</textarea>
                                            @error('bio') <p class="small text-danger">{{ $message }}</p> @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="company" class="col-sm-2 col-form-label">Company name</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="company" placeholder="Company name" name="company" value="{{ old('company') ? old('company') : auth()->guard('admin')->user()->company }}">
                                            @error('company') <p class="small text-danger">{{ $message }}</p> @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="designation" class="col-sm-2 col-form-label">Designation</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="designation" placeholder="Designation" name="designation" value="{{ old('designation') ? old('designation') : auth()->guard('admin')->user()->designation }}">
                                            @error('designation') <p class="small text-danger">{{ $message }}</p> @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="location_info" class="col-sm-2 col-form-label">Location</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="location_info" placeholder="Location information" name="location_info" value="{{ old('location_info') ? old('location_info') : auth()->guard('admin')->user()->location_info }}">
                                            @error('location_info') <p class="small text-danger">{{ $message }}</p> @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="skills" class="col-sm-2 col-form-label">Skills</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="skills" placeholder="Skills" name="skills" value="{{ old('skills') ? old('skills') : auth()->guard('admin')->user()->skills }}">
                                            @error('skills') <p class="small text-danger">{{ $message }}</p> @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="experience" class="col-sm-2 col-form-label">Experience</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" id="experience" placeholder="experience" name="experience">{{ old('experience') ? old('experience') : auth()->guard('admin')->user()->experience }}</textarea>
                                            @error('experience') <p class="small text-danger">{{ $message }}</p> @enderror
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