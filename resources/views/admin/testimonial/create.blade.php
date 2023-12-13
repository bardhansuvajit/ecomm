@extends('admin.layout.app')
@section('page-title', 'Create testimonial')

@section('section')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row mb-3">
                            <div class="col-md-12 text-right">
                                <a href="{{ route('admin.management.testimonial.list.all') }}" class="btn btn-sm btn-primary"> <i class="fa fa-chevron-left"></i> Back</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.management.testimonial.store') }}" method="post" enctype="multipart/form-data">@csrf
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="image">Image *</label>
                                    <input type="file" class="form-control" name="image" id="image">
                                    {!! imageUploadNotice('testimonial')['html'] !!}
                                    @error('image') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="name">Name * <span class="text-muted">(within 25 characters)</span></label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter title 1" value="{{ old('name') }}" maxlength="25">
                                    @error('name') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="designation">Designation * <span class="text-muted">(within 25 characters)</span></label>
                                    <input type="text" class="form-control" name="designation" id="designation" placeholder="Enter title 2" value="{{ old('designation') }}" maxlength="25">
                                    @error('designation') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="comment">Comment *</label>
                                <textarea name="comment" id="comment" class="form-control" placeholder="Enter comment" rows="4">{{ old('comment') }}</textarea>
                                @error('comment') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                            {{-- <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="btn_text">Button text <span class="text-muted">(within 25 characters)</span></label>
                                    <input type="text" class="form-control" name="btn_text" id="btn_text" placeholder="Enter button text" value="{{ old('btn_text') }}" maxlength="25">
                                    @error('btn_text') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="btn_link">Button link</label>
                                    <input type="text" class="form-control" name="btn_link" id="btn_link" placeholder="Enter button link" value="{{ old('btn_link') }}">
                                    @error('btn_link') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div> --}}

                            <button type="submit" class="btn btn-primary">Upload</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
