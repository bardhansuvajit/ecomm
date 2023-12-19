@extends('admin.layout.app')
@section('page-title', 'Edit banner')

@section('section')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row mb-3">
                            <div class="col-md-12 text-right">
                                <a href="{{ route('admin.content.banner.list.all') }}" class="btn btn-sm btn-primary"> <i class="fa fa-chevron-left"></i> Back</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.content.banner.update') }}" method="post" enctype="multipart/form-data">@csrf
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-3">
                                            @if (!empty($data->desktop_image_small) && file_exists(public_path($data->desktop_image_small)))
                                                <img src="{{ asset($data->desktop_image_small) }}" alt="image" class="img-thumbnail edit-image">
                                            @else
                                                <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" alt="image" class="img-thumbnail edit-image">
                                            @endif
                                        </div>
                                        <div class="col-md-9">
                                            <label for="desktop_image">Desktop Image <span class="text-muted">(Optional)</span></label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="desktop_image" id="desktop_image">
                                                    <label class="custom-file-label" for="desktop_image">Choose file</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <p>{!! imageUploadNotice('desktop_banner')['html'] !!}</p>

                                    @error('desktop_image') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>

                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-3">
                                            @if (!empty($data->mobile_image_small) && file_exists(public_path($data->mobile_image_small)))
                                                <img src="{{ asset($data->mobile_image_small) }}" alt="image" class="img-thumbnail edit-image">
                                            @else
                                                <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" alt="image" class="img-thumbnail edit-image">
                                            @endif
                                        </div>
                                        <div class="col-md-9">
                                            <label for="mobile_image">Mobile Image <span class="text-muted">(Optional)</span></label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="mobile_image" id="mobile_image">
                                                    <label class="custom-file-label" for="mobile_image">Choose file</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <p>{!! imageUploadNotice('mobile_banner')['html'] !!}</p>

                                    @error('mobile_image') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <hr>

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="web_link">Web link <span class="text-muted">*</span></label>
                                    <input type="text" class="form-control" name="web_link" id="web_link" placeholder="Enter web link" value="{{ old('web_link') ? old('web_link') : $data->web_link }}" maxlength="255">
                                    @error('web_link') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="app_link">App link <span class="text-muted">(Optional)</span></label>
                                    <input type="text" class="form-control" name="app_link" id="app_link" placeholder="Enter application link" value="{{ old('app_link') ? old('app_link') : $data->app_link }}" maxlength="255">
                                    @error('app_link') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <hr>

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="title1">Title 1 <span class="text-muted">(Optional - within 25 characters)</span></label>
                                    <input type="text" class="form-control" name="title1" id="title1" placeholder="Enter title 1" value="{{ old('title1') ? old('title1') : $data->title1 }}" maxlength="25">
                                    @error('title1') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="title2">Title 2 <span class="text-muted">(Optional - within 25 characters)</span></label>
                                    <input type="text" class="form-control" name="title2" id="title2" placeholder="Enter title 2" value="{{ old('title2') ? old('title2') : $data->title2 }}" maxlength="25">
                                    @error('title2') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="short_description">Short description <span class="text-muted">(Optional - within 200 characters)</span></label>
                                <textarea name="short_description" id="short_description" class="form-control" placeholder="Enter short description" rows="4">{{ old('short_description') ? old('short_description') : $data->short_description }}</textarea>
                                @error('short_description') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                            <div class="form-group">
                                <label for="detailed_description">Detailed description <span class="text-muted">(Optional - within 1000 characters)</span></label>
                                <textarea name="detailed_description" id="detailed_description" class="form-control" placeholder="Enter detailed description" rows="4">{{ old('detailed_description') ? old('detailed_description') : $data->detailed_description }}</textarea>
                                @error('detailed_description') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="btn_text">Button text <span class="text-muted">(Optional - within 25 characters)</span></label>
                                    <input type="text" class="form-control" name="btn_text" id="btn_text" placeholder="Enter button text" value="{{ old('btn_text') ? old('btn_text') : $data->btn_text }}" maxlength="25">
                                    @error('btn_text') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
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
