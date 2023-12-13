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
                                    @if (!empty($data->image_small))
                                        @if (!empty($data->image_small) && file_exists(public_path($data->image_small)))
                                            <img src="{{ asset($data->image_small) }}" alt="image" class="img-thumbnail mr-3" style="height: 50px">
                                        @else
                                            <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" alt="image" style="height: 50px" class="mr-2">
                                        @endif
                                        <br>
                                    @endif

                                    <label for="image">Image</label>
                                    <input type="file" class="form-control" name="image" id="image">
                                    {!! imageUploadNotice('banner')['html'] !!}
                                    @error('image') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>

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

                            <div class="form-group row">
                                <label for="short_description">Short description <span class="text-muted">(Optional - within 200 characters)</span></label>
                                <textarea name="short_description" id="short_description" class="form-control" placeholder="Enter short description" rows="4">{{ old('short_description') ? old('short_description') : $data->short_description }}</textarea>
                                @error('short_description') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                            <div class="form-group row">
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
                                <div class="col-md-6">
                                    <label for="btn_link">Button link <span class="text-muted">(Optional)</span></label>
                                    <input type="text" class="form-control" name="btn_link" id="btn_link" placeholder="Enter button link" value="{{ old('btn_link') ? old('btn_link') : $data->btn_link }}">
                                    @error('btn_link') <p class="small text-danger">{{ $message }}</p> @enderror
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
