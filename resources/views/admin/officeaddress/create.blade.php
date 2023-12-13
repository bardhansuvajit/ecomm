@extends('admin.layout.app')
@section('page-title', 'Create office address')

@section('section')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row mb-3">
                            <div class="col-md-12 text-right">
                                <a href="{{ route('admin.office.address.list.all') }}" class="btn btn-sm btn-primary"> <i class="fa fa-chevron-left"></i> Back</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.office.address.store') }}" method="post" enctype="multipart/form-data">@csrf
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="type">Type <span class="text-muted">*</span></label>
                                    <input type="text" class="form-control" name="type" id="type" placeholder="Office type | eg: Headoffice" value="{{ old('type') }}">
                                    @error('type') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="title">Title <span class="text-muted">*</span></label>
                                    <input type="text" class="form-control" name="title" id="title" placeholder="Office name | eg: {{ $officeInfo->full_name }}" value="{{ old('title') }}">
                                    @error('title') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="street_address">Street address <span class="text-muted">*</span></label>
                                <textarea name="street_address" id="street_address" class="form-control" placeholder="Enter Street address" rows="4">{{ old('street_address') }}</textarea>
                                @error('street_address') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label for="pincode">Pincode <span class="text-muted">*</span></label>
                                    <input type="text" class="form-control" name="pincode" id="pincode" placeholder="" value="{{ old('pincode') }}">
                                    @error('pincode') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="state">State <span class="text-muted">*</span></label>
                                    <input type="text" class="form-control" name="state" id="state" placeholder="" value="{{ old('state') }}">
                                    @error('state') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="country">Country <span class="text-muted">*</span></label>
                                    <input type="text" class="form-control" name="country" id="country" placeholder="" value="{{ old('country') }}">
                                    @error('country') <p class="small text-danger">{{ $message }}</p> @enderror
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
