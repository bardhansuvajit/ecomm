@extends('admin.layout.app')
@section('page-title', 'Edit office address')

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
                        <form action="{{ route('admin.office.address.update') }}" method="post" enctype="multipart/form-data">@csrf
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="type">Type <span class="text-muted">*</span></label>
                                    <input type="text" class="form-control" name="type" id="type" placeholder="Office type | eg: Headoffice" value="{{ old('type') ? old('type') : $data->type }}">
                                    @error('type') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="title">Title <span class="text-muted">*</span></label>
                                    <input type="text" class="form-control" name="title" id="title" placeholder="Office name | eg: {{ $officeInfo->full_name }}" value="{{ old('title') ? old('title') : $data->title }}">
                                    @error('title') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="street_address">Street address <span class="text-muted">*</span></label>
                                <textarea name="street_address" id="street_address" class="form-control" placeholder="Enter Street address" rows="4">{{ old('street_address') ? old('street_address') : $data->street_address }}</textarea>
                                @error('street_address') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label for="pincode">Pincode <span class="text-muted">*</span></label>
                                    <input type="text" class="form-control" name="pincode" id="pincode" placeholder="" value="{{ old('pincode') ? old('pincode') : $data->pincode }}">
                                    @error('pincode') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="state">State <span class="text-muted">*</span></label>
                                    <input type="text" class="form-control" name="state" id="state" placeholder="" value="{{ old('state') ? old('state') : $data->state }}">
                                    @error('state') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="country">Country <span class="text-muted">*</span></label>
                                    <input type="text" class="form-control" name="country" id="country" placeholder="" value="{{ old('country') ? old('country') : $data->country }}">
                                    @error('country') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            {{-- <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="btn_text">Button text <span class="text-muted">(within 25 characters)</span></label>
                                    <input type="text" class="form-control" name="btn_text" id="btn_text" placeholder="Enter Button text" value="{{ old('btn_text') ? old('btn_text') : $data->btn_text }}">
                                    @error('btn_text') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="btn_link">Button link</label>
                                    <input type="text" class="form-control" name="btn_link" id="btn_link" placeholder="Enter Button link" value="{{ old('btn_link') ? old('btn_link') : $data->btn_link }}">
                                    @error('btn_link') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div> --}}

                            <input type="hidden" name="id" value="{{ $data->id }}">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
