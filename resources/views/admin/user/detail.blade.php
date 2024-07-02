@extends('admin.layout.app')
@section('page-title', 'User detail')

@section('section')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row mb-3">
                            <div class="col-md-12 text-right">
                                <a href="{{ url()->previous() }}" class="btn btn-sm btn-primary"> <i class="fa fa-chevron-left"></i> Back</a>

                                <a href="{{ route('admin.user.edit', $data->id) }}" class="btn btn-sm btn-primary"> <i class="fa fa-edit"></i> Edit</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="small text-muted mb-0">Name</p>
                        <p class="text-dark">
                            {{ $data->first_name ? $data->first_name : 'NA' }}
                            {{ $data->last_name ? $data->last_name : 'NA' }}
                        </p>

                        <p class="small text-muted mb-0">Email</p>
                        <p class="text-dark">{{ $data->email ? $data->email : 'NA' }}</p>

                        <p class="small text-muted mb-0">Mobile number</p>
                        <p class="text-dark">{{ $data->mobile_no ? $data->mobile_no : 'NA' }}</p>

                        <p class="small text-muted mb-0">Whatsapp number</p>
                        <p class="text-dark">{{ $data->whatsapp_no ? $data->whatsapp_no : 'NA' }}</p>

                        <p class="small text-muted mb-0">Password @if($data->default_password_set == 1) <span class="badge badge-danger">Default password set</span>@endif </p>
                        <p class="">
                            <a href="#resetPassword" data-bs-toggle="modal" class="btn btn-sm btn-primary">Reset</a>
                        </p>

                        <p class="small text-muted mb-0">Gender</p>
                        <p class="text-dark">{{ $data->gender ? $data->gender : 'NA' }}</p>

                        <p class="small text-muted mb-0">Created at</p>
                        <p class="text-dark">{{ h_date($data->created_at) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="resetPassword" tabindex="-1" aria-labelledby="resetPasswordLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resetPasswordLabel">Reset password</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.user.reset.password') }}" method="post">@csrf
                    <div class="form-group">
                        <label for="password">Password <span class="text-muted">*</span></label>
                        <input type="text" class="form-control" name="password" id="password" placeholder="" value="{{ old('password') ? old('password') : mt_rand_custom(10) }}">
                        @error('password') <p class="small text-danger">{{ $message }}</p> @enderror
                    </div>

                    <input type="hidden" name="id" value="{{ $data->id }}">
                    <button type="submit" class="btn btn-primary">Reset</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

