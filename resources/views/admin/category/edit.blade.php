@extends('admin.layout.app')
@section('page-title', 'Edit category '.$level)

@section('section')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row mb-3">
                            <div class="col-md-12 text-right">
                                <a href="{{ route('admin.product.category.list.all', $level) }}" class="btn btn-sm btn-primary"> <i class="fa fa-chevron-left"></i> Back</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.product.category.update', $level) }}" method="post" enctype="multipart/form-data">@csrf
                            @if ($level != 1)
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="parent_id">Parent category <span class="text-muted">*</span></label>
                                    <select name="parent_id" id="parent_id" class="form-select">
                                        <option value="" selected disabled>Select...</option>
                                        @foreach ($parentCategory as $item)
                                            <option value="{{ $item->id }}"
                                            @if ($level == 2)
                                                {{ ($data->cat1_id == $item->id) ? 'selected' : '' }}
                                            @elseif ($level == 3)
                                                {{ ($data->cat2_id == $item->id) ? 'selected' : '' }}
                                            @else
                                                {{ ($data->cat3_id == $item->id) ? 'selected' : '' }}
                                            @endif    
                                            >{{ $item->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('parent_id') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            @endif

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-3">
                                            @if (!empty($data->icon_small) && file_exists(public_path($data->icon_small)))
                                                <img src="{{ asset($data->icon_small) }}" alt="image" class="img-thumbnail edit-image">
                                            @else
                                                <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" alt="image" class="img-thumbnail edit-image">
                                            @endif
                                        </div>
                                        <div class="col-md-9">
                                            <label for="icon">Icon <span class="text-muted">(Optional)</span></label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="icon" id="icon">
                                                    <label class="custom-file-label" for="icon">Choose file</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <p>{!! imageUploadNotice('category-icon')['html'] !!}</p>

                                    @error('icon') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>

                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-3">
                                            @if (!empty($data->icon_small) && file_exists(public_path($data->icon_small)))
                                                <img src="{{ asset($data->icon_small) }}" alt="image" class="img-thumbnail edit-image">
                                            @else
                                                <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" alt="image" class="img-thumbnail edit-image">
                                            @endif
                                        </div>
                                        <div class="col-md-9">
                                            <label for="banner">Banner <span class="text-muted">(Optional)</span></label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="banner" id="banner">
                                                    <label class="custom-file-label" for="banner">Choose file</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <p>{!! imageUploadNotice('category-banner')['html'] !!}</p>

                                    @error('banner') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="title">Title <span class="text-muted">*</span></label>
                                <input type="text" class="form-control" name="title" id="title" placeholder="Enter title" value="{{ old('title') ? old('title') : $data->title }}" maxlength="255" autofocus>
                                @error('title') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                            <div class="form-group">
                                <label for="short_desc">Short description <span class="text-muted">(Optional - within 1000 characters)</span></label>
                                <textarea name="short_desc" id="short_desc" class="form-control" placeholder="Enter short description">{{ old('short_desc') ? old('short_desc') : $data->short_desc }}</textarea>
                                @error('short_desc') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                            <div class="form-group">
                                <label for="detailed_desc">Detailed description <span class="text-muted">(Optional)</span></label>
                                <textarea name="detailed_desc" id="detailed_desc" class="form-control ckeditor" placeholder="Enter Long description" rows="6">{{ old('detailed_desc') ? old('detailed_desc') : $data->detailed_desc }}</textarea>
                                @error('detailed_desc') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                            <hr>

                            <div class="form-group">
                                <label for="page_title">Page title <span class="text-muted">(Optional)</span></label>
                                <textarea name="page_title" id="page_title" class="form-control" placeholder="Enter Page title">{{ old('page_title') ? old('page_title') : $data->page_title }}</textarea>
                                @error('page_title') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                            <div class="form-group">
                                <label for="meta_title">Meta title <span class="text-muted">(Optional)</span></label>
                                <textarea name="meta_title" id="meta_title" class="form-control" placeholder="Enter Meta title">{{ old('meta_title') ? old('meta_title') : $data->meta_title }}</textarea>
                                @error('meta_title') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                            <div class="form-group">
                                <label for="meta_desc">Meta Description <span class="text-muted">(Optional)</span></label>
                                <textarea name="meta_desc" id="meta_desc" class="form-control" placeholder="Enter Meta Description">{{ old('meta_desc') ? old('meta_desc') : $data->meta_desc }}</textarea>
                                @error('meta_desc') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                            <div class="form-group">
                                <label for="meta_keyword">Meta Keyword <span class="text-muted">(Optional)</span></label>
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
