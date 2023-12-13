@extends('admin.layout.app')
@section('page-title', 'Create user')

@section('section')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row mb-3">
                            <div class="col-md-12 text-right">
                                <a href="{{ route('admin.user.list.all') }}" class="btn btn-sm btn-primary"> <i class="fa fa-chevron-left"></i> Back</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.user.store') }}" method="post">@csrf
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label for="first_name">First name <span class="text-muted">*</span></label>
                                    <input type="text" class="form-control" name="first_name" id="first_name" placeholder="" value="{{ old('first_name') }}" autofocus>
                                    @error('first_name') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="last_name">Last name <span class="text-muted">*</span></label>
                                    <input type="text" class="form-control" name="last_name" id="last_name" placeholder="" value="{{ old('last_name') }}">
                                    @error('last_name') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label for="email">Email <span class="text-muted">*</span></label>
                                    <input type="email" class="form-control" name="email" id="email" placeholder="" value="{{ old('email') }}">
                                    @error('email') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="mobile_no">Mobile number <span class="text-muted">*</span></label>
                                    <input type="number" class="form-control" name="mobile_no" id="mobile_no" placeholder="" value="{{ old('mobile_no') }}">
                                    @error('mobile_no') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="whatsapp_no">Whatsapp number <span class="text-muted">(Optional)</span></label>
                                    <input type="number" class="form-control" name="whatsapp_no" id="whatsapp_no" placeholder="" value="{{ old('whatsapp_no') }}">
                                    @error('whatsapp_no') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label for="password">Password <span class="text-muted">*</span></label>
                                    <input type="text" class="form-control" name="password" id="password" placeholder="" value="{{ old('password') ? old('password') : mt_rand_custom(10) }}">
                                    @error('password') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-8">
                                    <label for="whatsapp_no">Gender <span class="text-muted">(Optional)</span></label>
                                    <br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="male" value="male" {{ (old('gender') == 'male') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="male">Male</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="female" value="female" {{ (old('gender') == 'female') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="female">Female</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="other" value="other" {{ (old('gender') == 'other') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="other">Other</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="not-specified" value="not specified"  {{ (old('gender')) ? ((old('gender') == 'not specified') ? 'checked' : '') : 'checked' }}>
                                        <label class="form-check-label" for="not-specified">Not specified</label>
                                    </div>
                                    @error('gender') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Upload</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
