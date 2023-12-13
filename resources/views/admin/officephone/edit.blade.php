@extends('admin.layout.app')
@section('page-title', 'Edit office phone number')

@section('section')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row mb-3">
                            <div class="col-md-12 text-right">
                                <a href="{{ route('admin.office.phone.list.all') }}" class="btn btn-sm btn-primary"> <i class="fa fa-chevron-left"></i> Back</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.office.phone.update') }}" method="post" enctype="multipart/form-data">@csrf
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="number">Phone number <span class="text-muted">*</span></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <input type="text" name="country_code" id="country_code" class="form-control" placeholder="Country code" value="{{ old('country_code') ? old('country_code') : $data->country_code }}">
                                        </div>
                                        <input type="text" name="number" id="number" class="form-control" placeholder="Phone number" value="{{ old('number') ? old('number') : $data->number }}" autofocus>
                                    </div>
                                    @error('country_code') <p class="small text-danger">{{ $message }}</p> @enderror
                                    @error('number') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="type">Type <span class="text-muted">*</span></label>
                                    <input type="text" class="form-control" name="type" id="type" placeholder="Type | eg: sales/ information" value="{{ old('type') ? old('type') : $data->type }}">
                                    @error('type') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="purpose">Purpose <span class="text-muted">(Optional)</span></label>
                                <input type="text" class="form-control" name="purpose" id="purpose" placeholder="Purpose | eg: for sales related enquiry" value="{{ old('purpose') ? old('purpose') : $data->purpose }}">
                                @error('purpose') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                            <div class="form-group">
                                <label for="purpose_description">Purpose description <span class="text-muted">(Optional)</span></label>
                                <textarea name="purpose_description" id="purpose_description" class="form-control" placeholder="Enter purpose description" rows="4">{{ old('purpose_description') ? old('purpose_description') : $data->purpose_description }}</textarea>
                                @error('purpose_description') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

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
