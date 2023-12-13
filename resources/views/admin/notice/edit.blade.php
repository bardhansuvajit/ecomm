@extends('admin.layout.app')
@section('page-title', 'Edit notice')

@section('section')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row mb-3">
                            <div class="col-md-12 text-right">
                                <a href="{{ route('admin.management.notice.list.all') }}" class="btn btn-sm btn-primary"> <i class="fa fa-chevron-left"></i> Back</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.management.notice.update') }}" method="post" enctype="multipart/form-data">@csrf
                            <div class="form-group row">
                                <div class="col-md-6">
                                    @if (!empty($data->image_small))
                                        @if (!empty($data->image_small) && file_exists(public_path($data->image_small)))
                                            <img src="{{ asset($data->image_small) }}" alt="banner-img" class="img-thumbnail mr-3" style="height: 50px">
                                        @else
                                            <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" alt="banner-image" style="height: 50px" class="mr-2">
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
                                <div class="col-md-12">
                                    <label for="text">Text</label>
                                    <textarea name="text" id="text" class="form-control" placeholder="Write notice here" rows="4">{{ old('text') ? old('text') : $data->text }}</textarea>
                                    @error('text') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="link">Link <span class="text-muted">(Optional)</span></label>
                                    <input type="text" class="form-control" name="link" id="link" placeholder="Enter redirect URL" value="{{ old('link') ? old('link') : $data->link }}" maxlength="25">
                                    @error('link') <p class="small text-danger">{{ $message }}</p> @enderror
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
