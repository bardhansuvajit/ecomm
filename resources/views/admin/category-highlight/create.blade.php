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
                                <a href="{{ route('admin.category.highlight.list.all', $id) }}" class="btn btn-sm btn-primary"> <i class="fa fa-chevron-left"></i> Back</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.category.highlight.store') }}" method="post" enctype="multipart/form-data">@csrf
                            <div class="row form-group">
                                <div class="col-md-6">
                                    <label for="image">Image *</label>
                                    <input type="file" class="form-control" name="image" id="image">
                                    {!! imageUploadNotice('category-highlight')['html'] !!}
                                    @error('image') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="category_id">Category *</label>
                                    <select name="category_id" id="category_id" class="form-control">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ ( $category->id == $id ) ? 'selected' : '' }} >{{ $category->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="title">Title * <span class="text-muted">(within 255 characters)</span></label>
                                    <input type="text" class="form-control" name="title" id="title" placeholder="Enter title 1" value="{{ old('title') }}" maxlength="255">
                                    @error('title') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="link">Redirect link <span class="text-muted">(Optional)</span> </label>
                                    <input type="text" class="form-control" name="link" id="link" placeholder="Enter title 2" value="{{ old('link') }}" maxlength="25">
                                    @error('link') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="short_details">Short details *</label>
                                <textarea name="short_details" id="short_details" class="form-control" placeholder="Enter short_details" rows="4">{{ old('short_details') }}</textarea>
                                @error('short_details') <p class="small text-danger">{{ $message }}</p> @enderror
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
