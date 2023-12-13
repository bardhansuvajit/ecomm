@extends('admin.layout.app')
@section('page-title', 'Edit product')

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
                                <a href="{{ route('admin.product.list.all') }}" class="btn btn-sm btn-primary"> <i class="fa fa-chevron-left"></i> Back</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.product.update') }}" method="post" enctype="multipart/form-data">@csrf
                            <div class="form-group">
                                <label for="type">Type *</label>
                                <select class="form-control" name="type" id="type">
                                    <option value="" disabled>Select</option>
                                    <option value="1" {{ ($data->type == 1) ? 'selected' : '' }}>Product</option>
                                    <option value="2" {{ ($data->type == 2) ? 'selected' : '' }}>Kit</option>
                                </select>
                                @error('type') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                            @if (!empty($data->frontImageDetails) && count($data->frontImageDetails) > 0)
                                <div class="row">
                                    @foreach ($data->frontImageDetails as $image)
                                        <div class="img-holder position-relative">
                                            @if (!empty($image->img_small) && file_exists(public_path($image->img_small)))
                                                <img src="{{ asset($image->img_small) }}" alt="image" class="img-thumbnail mr-3" style="height: 80px">
                                            @else
                                                <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" alt="image" style="height: 50px" class="mr-2">
                                            @endif
                                            <a href="{{ route('admin.product.image.delete', $image->id) }}" style="position: absolute;top: -5px;right: 15px;" onclick="return confirm('Are you sure ?')" data-toggle="tooltip" title="Delete image">
                                                <i class="fa fa-times text-danger"></i>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                                <hr>
                            @endif
                            <div class="row form-group">
                                <div class="col-md-6">
                                    <label for="images">Images</label>
                                    <input type="file" class="form-control" name="images[]" id="images" multiple>
                                    @error('images') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label>Category *</label>
                                    <select class="form-control" name="category_id">
                                        <option value="" selected disabled>Select</option>
                                        @forelse ($activeCategories as $category)
                                            <option value="{{$category->id}}" {{ ($data->category_id == $category->id) ? 'selected' : '' }}>{{$category->title}}</option>
                                        @empty
                                            <option value="">No data found</option>
                                        @endforelse
                                    </select>
                                    @error('category_id') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="title">Title *</label>
                                <input type="text" class="form-control" name="title" id="title" placeholder="Enter title" value="{{ old('title') ? old('title') : $data->title }}">
                                @error('title') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                            <div class="form-group">
                                <label for="short_description">Short description</label>
                                <textarea name="short_description" id="short_description" class="form-control" placeholder="Enter short description">{{ old('short_description') ? old('short_description') : $data->short_description }}</textarea>
                                @error('short_description') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                            <div class="form-group">
                                <label for="key_feature">Key feature</label>
                                @forelse ($data->keyFeatures as $featureKey => $feature)
                                    <div class="multi-ext-links">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Enter feature details" name="key_feature[]" value="{{$feature->title}}">
                                            <div class="input-group-append">
                                                @if ($featureKey > 0)
                                                    <a href="javascript:void(0)" class="input-group-text remove-ext-link">
                                                        <i class="fas fa-times"></i>
                                                    </a>
                                                @else
                                                    <a href="javascript:void(0)" class="input-group-text add-ext-link">
                                                        <i class="fas fa-plus"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="multi-ext-links">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Enter feature details" name="key_feature[]">
                                            <div class="input-group-append">
                                                <a href="javascript:void(0)" class="input-group-text add-ext-link">
                                                    <i class="fas fa-plus"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforelse

                                <div id="other-features"></div>
                            </div>

                            <div class="form-group">
                                <label for="box_items">What's in the box</label>
                                @forelse ($data->boxItems as $itemKey => $item)
                                    <div class="multi-box-links">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Enter items" name="box_items[]" value="{{$item->title}}">
                                            <div class="input-group-append">
                                                @if ($itemKey > 0)
                                                    <a href="javascript:void(0)" class="input-group-text remove-box-link">
                                                        <i class="fas fa-times"></i>
                                                    </a>
                                                @else
                                                    <a href="javascript:void(0)" class="input-group-text add-box-link">
                                                        <i class="fas fa-plus"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="multi-box-links">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Enter items" name="box_items[]">
                                            <div class="input-group-append">
                                                <a href="javascript:void(0)" class="input-group-text add-box-link">
                                                    <i class="fas fa-plus"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforelse

                                <div id="other-items"></div>
                            </div>

                            <div class="form-group">
                                <label for="manual_title">Manual</label>

                                @if (count($data->manuals) > 0)
                                    <div class="row mb-3">
                                        @foreach ($data->manuals as $manual)
                                            <div class="col-12">
                                                <a href="{{ asset($manual->file_path) }}" class="text-primary mb-0" target="_blank">{{ $manual->title }}</a>

                                                <a href="{{ route('admin.product.manual.delete', $manual->id) }}" onclick="return confirm('Are you sure ?')" data-toggle="tooltip" title="Delete Manual">
                                                    <i class="fa fa-times text-danger"></i>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                <div class="multi-manual-links">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Enter title" name="manual_title[]">
                                        <input type="file" class="form-control" name="manual_file[]" accept=".pdf">
                                        <div class="input-group-append">
                                            <a href="javascript:void(0)" class="input-group-text add-manual-link">
                                                <i class="fas fa-plus"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div id="manual-items"></div>
                            </div>

                            <div class="form-group">
                                <label for="datasheet_title">Datasheet</label>

                                @if (count($data->datasheets) > 0)
                                    <div class="row mb-3">
                                        @foreach ($data->datasheets as $sheet)
                                            <div class="col-12">
                                                <a href="{{ asset($sheet->file_path) }}" class="text-primary mb-0" target="_blank">{{ $sheet->title }}</a>

                                                <a href="{{ route('admin.product.datasheet.delete', $sheet->id) }}" onclick="return confirm('Are you sure ?')" data-toggle="tooltip" title="Delete Datasheet">
                                                    <i class="fa fa-times text-danger"></i>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                <div class="multi-datasheet-links">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Enter title" name="datasheet_title[]">
                                        <input type="file" class="form-control" name="datasheet_file[]" accept=".pdf">
                                        <div class="input-group-append">
                                            <a href="javascript:void(0)" class="input-group-text add-datasheet-link">
                                                <i class="fas fa-plus"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div id="datasheet-items"></div>
                            </div>

                            <div class="form-group">
                                <label for="overview">Overview</label>
                                <textarea name="overview" id="overview" class="form-control ckeditor" placeholder="Enter Overview">{{ old('overview') ? old('overview') : $data->overview }}</textarea>
                                @error('overview') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                            <div class="form-group">
                                <label for="specification">Specifications</label>
                                <textarea name="specification" id="specification" class="form-control ckeditor" placeholder="Enter Specifications">{{ old('specification') ? old('specification') : $data->specification }}</textarea>
                                @error('specification') <p class="small text-danger">{{ $message }}</p> @enderror
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

                            <input type="hidden" name="product_id" value="{{$data->id}}">
                            <button type="submit" class="btn btn-primary">Upload</button>
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

    <script>
        $('.add-ext-link').on('click', function() {
            var content = `
            <div class="multi-ext-links">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Enter feature details" name="key_feature[]">
                    <div class="input-group-append">
                        <a href="javascript:void(0)" class="input-group-text remove-ext-link">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </div>
            </div>
            `;

            $('#other-features').append(content);
        });

        $(document).on('click', '.remove-ext-link', function() {
            $(this).closest(".multi-ext-links").remove();
        });

        $('.add-box-link').on('click', function() {
            var content = `
            <div class="multi-box-links">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Enter items" name="box_items[]">
                    <div class="input-group-append">
                        <a href="javascript:void(0)" class="input-group-text remove-box-link">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </div>
            </div>
            `;

            $('#other-items').append(content);
        });

        $(document).on('click', '.remove-box-link', function() {
            $(this).closest(".multi-box-links").remove();
        });

        $('.add-manual-link').on('click', function() {
            var content = `
            <div class="multi-manual-links">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Enter title" name="manual_title[]">
                    <input type="file" class="form-control" name="manual_file[]" accept=".pdf">
                    <div class="input-group-append">
                        <a href="javascript:void(0)" class="input-group-text remove-manual-link">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </div>
            </div>
            `;

            $('#manual-items').append(content);
        });

        $(document).on('click', '.remove-manual-link', function() {
            $(this).closest(".multi-manual-links").remove();
        });

        $('.add-datasheet-link').on('click', function() {
            var content = `
            <div class="multi-datasheet-links">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Enter title" name="datasheet_title[]">
                    <input type="file" class="form-control" name="datasheet_file[]" accept=".pdf">
                    <div class="input-group-append">
                        <a href="javascript:void(0)" class="input-group-text remove-datasheet-link">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </div>
            </div>
            `;

            $('#datasheet-items').append(content);
        });

        $(document).on('click', '.remove-datasheet-link', function() {
            $(this).closest(".multi-datasheet-links").remove();
        });
    </script>
@endsection