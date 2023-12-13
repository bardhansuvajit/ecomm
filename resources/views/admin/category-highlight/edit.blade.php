@extends('admin.layout.app')
@section('page-title', 'Create category highlight')

@section('section')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row mb-3">
                            <div class="col-md-12 text-right">
                                <a href="{{ route('admin.category.highlight.list.all', $data->category_id) }}" class="btn btn-sm btn-primary"> <i class="fa fa-chevron-left"></i> Back</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.category.highlight.update') }}" method="post" enctype="multipart/form-data">@csrf
                            <div class="row form-group">
                                <div class="col-md-6">
                                    @if (!empty($data->image_small) && file_exists(public_path($data->image_small)))
                                        <img src="{{ asset($data->image_small) }}" alt="image" class="img-thumbnail mb-3" style="height: 100px">
                                    @else
                                        <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" alt="image" style="height: 50px" class="mb-3">
                                    @endif
                                    <br>
                                    <label for="image">Image *</label>
                                    <input type="file" class="form-control" name="image" id="image">
                                    {!! imageUploadNotice('category-highlight')['html'] !!}
                                    @error('image') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-md-6">
                                    <label for="category_id">Category *</label>
                                    <select name="category_id" id="category_id" class="form-control">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ ( $category->id == $data->category_id ) ? 'selected' : '' }} >{{ $category->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="title">Title * <span class="text-muted">(within 255 characters)</span></label>
                                    <input type="text" class="form-control" name="title" id="title" placeholder="Enter title 1" value="{{ old('title') ? old('title') : $data->title }}" maxlength="255">
                                    @error('title') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="link">Redirect link  <span class="text-muted">(Optional)</span> </label>
                                    <input type="text" class="form-control" name="link" id="link" placeholder="Enter title 2" value="{{ old('link') ? old('link') : $data->link }}" maxlength="25">
                                    @error('link') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="short_details">Short details *</label>
                                <textarea name="short_details" id="short_details" class="form-control" placeholder="Enter short_details" rows="4">{{ old('short_details') ? old('short_details') : $data->short_details }}</textarea>
                                @error('short_details') <p class="small text-danger">{{ $message }}</p> @enderror
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
