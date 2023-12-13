@extends('admin.layout.app')
@section('page-title', 'Edit Service')

@section('style')
<link rel="stylesheet" href="{{ asset('backend-assets/plugins/ckeditor5-36.0.1-sy1shf6t1itx/content-styles.css') }}">
@endsection

@section('section')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row mb-3">
                            <div class="col-md-12 text-right">
                                <a href="{{ route('admin.service.list.all') }}" class="btn btn-sm btn-primary"> <i class="fa fa-chevron-left"></i> Back</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.service.update') }}" method="post" enctype="multipart/form-data">@csrf
                            <div class="row form-group">
                                <div class="col-md-6">
                                    <label for="category_id">Category *</label>
                                    <select class="form-control" name="category_id" id="category_id">
                                        <option value="" selected disabled>Select</option>
                                        @forelse ($categories as $category)
                                            <option value="{{$category->id}}" {{ ($data->category_id == $category->id) ? 'selected' : '' }}>{{$category->title}}</option>
                                        @empty
                                            <option value="">No data found</option>
                                        @endforelse
                                    </select>
                                    @error('category_id') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="subcategory_id">Sub-Category</label>
                                    <select class="form-control" name="subcategory_id" id="subcategory_id">
                                        <option value="" selected disabled>Select</option>
                                        @forelse ($subcategories as $subcategory)
                                            <option value="{{$subcategory->id}}" {{ ($data->subcategory_id == $subcategory->id) ? 'selected' : '' }}>{{$subcategory->title}}</option>
                                        @empty
                                            <option value="">No data found</option>
                                        @endforelse
                                    </select>
                                    @error('subcategory_id') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                @if (!empty($data->image_small))
                                    @if (!empty($data->image_small) && file_exists(public_path($data->image_small)))
                                        <img src="{{ asset($data->image_small) }}" alt="service-img" class="img-thumbnail mr-3" style="height: 50px">
                                    @else
                                        <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" alt="service-image" style="height: 50px" class="mr-2">
                                    @endif
                                    <br>
                                @endif

                                <label for="image">Image</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="image" id="image">
                                        <label class="custom-file-label" for="image">Choose file</label>
                                    </div>
                                </div>
                                {!! imageUploadNotice('service')['html'] !!}
                                @error('image') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                            <div class="form-group">
                                <label for="title">Title *</label>
                                <input type="text" class="form-control" name="title" id="title" placeholder="Enter title" value="{{ old('title') ? old('title') : $data->title }}">
                                @error('title') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                            <div class="form-group">
                                <label for="short_desc">Short description <span class="text-muted">(within 100 characters)</span></label>
                                <textarea name="short_desc" id="short_desc" class="form-control" placeholder="Enter short description">{{ old('short_desc') ? old('short_desc') : $data->short_desc }}</textarea>
                                @error('short_desc') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                            <div class="form-group">
                                <label for="long_desc">Long description</label>
                                <textarea name="long_desc" id="long_desc" class="form-control ckeditor" placeholder="Enter Long description" rows="6">{{ old('long_desc') ? old('long_desc') : $data->long_desc }}</textarea>
                                @error('long_desc') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                            <hr>

                            <div class="form-group">
                                <label for="page_title">Page title</label>
                                <textarea name="page_title" id="page_title" class="form-control" placeholder="Enter Page title">{{ old('page_title') ? old('page_title') : $data->page_title }}</textarea>
                                @error('page_title') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                            <div class="form-group">
                                <label for="meta_title">Meta title</label>
                                <textarea name="meta_title" id="meta_title" class="form-control" placeholder="Enter Meta title">{{ old('meta_title') ? old('meta_title') : $data->meta_title }}</textarea>
                                @error('meta_title') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                            <div class="form-group">
                                <label for="meta_desc">Meta Description</label>
                                <textarea name="meta_desc" id="meta_desc" class="form-control" placeholder="Enter Meta Description">{{ old('meta_desc') ? old('meta_desc') : $data->meta_desc }}</textarea>
                                @error('meta_desc') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                            <div class="form-group">
                                <label for="meta_keyword">Meta Keyword</label>
                                <textarea name="meta_keyword" id="meta_keyword" class="form-control" placeholder="Enter Meta Keyword">{{ old('meta_keyword') ? old('meta_keyword') : $data->meta_keyword }}</textarea>
                                @error('meta_keyword') <p class="small text-danger">{{ $message }}</p> @enderror
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

@section('script')
    <script src="{{ asset('backend-assets/plugins/ckeditor5-36.0.1-sy1shf6t1itx/build/ckeditor.js') }}"></script>
    <script src="{{ asset('backend-assets/js/ckeditor-custom.js') }}"></script>
@endsection