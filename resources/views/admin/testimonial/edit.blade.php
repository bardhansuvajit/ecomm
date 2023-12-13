@extends('admin.layout.app')
@section('page-title', 'Edit testimonial')

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
                        <form action="{{ route('admin.management.testimonial.update') }}" method="post" enctype="multipart/form-data">@csrf
                            <div class="row form-group">
                                <div class="col-md-6">
                                    @if (!empty($data->image_medium))
                                        @if (!empty($data->image_medium) && file_exists(public_path($data->image_medium)))
                                            <img src="{{ asset($data->image_medium) }}" alt="testimonial-img" class="img-thumbnail mr-3" style="height: 50px">
                                        @else
                                            <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" alt="image" style="height: 50px" class="mr-2">
                                        @endif
                                        <br>
                                    @endif

                                    <label for="image">Image</label>
                                    <input type="file" class="form-control" name="image" id="image">
                                    {!! imageUploadNotice('testimonial')['html'] !!}
                                    @error('image') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="name">Name * <span class="text-muted">(within 25 characters)</span></label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter title 1" value="{{ old('name') ? old('name') : $data->name }}" maxlength="25">
                                    @error('name') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="designation">Designation * <span class="text-muted">(within 25 characters)</span></label>
                                    <input type="text" class="form-control" name="designation" id="designation" placeholder="Enter title 2" value="{{ old('designation') ? old('designation') : $data->designation }}" maxlength="25">
                                    @error('designation') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="comment">Comment <span class="text-muted">(within 70 characters)</span></label>
                                <textarea name="comment" id="comment" class="form-control" placeholder="Enter comment" rows="4">{{ old('comment') ? old('comment') : $data->comment }}</textarea>
                                @error('comment') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                            {{-- <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="btn_text">Button text <span class="text-muted">(within 25 characters)</span></label>
                                    <input type="text" class="form-control" name="btn_text" id="btn_text" placeholder="Enter Button text" value="{{ old('btn_text') ? old('btn_text') : $data->btn_text }}" maxlength="25">
                                    @error('btn_text') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="btn_link">Button link</label>
                                    <input type="text" class="form-control" name="btn_link" id="btn_link" placeholder="Enter Button link" value="{{ old('btn_link') ? old('btn_link') : $data->btn_link }}" maxlength="25">
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
