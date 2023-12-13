@extends('admin.layout.app')
@section('page-title', 'Service detail')

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

                                <a href="{{ route('admin.service.edit', $data->id) }}" class="btn btn-sm btn-primary"> <i class="fa fa-edit"></i> Edit</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="small text-muted mb-0">Image</p>
                        @if (!empty($data->image_small) && file_exists(public_path($data->image_small)))
                            <img src="{{ asset($data->image_small) }}" alt="image" style="height: 50px" class="img-thumbnail mr-2 mb-3">
                        @else
                            <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" alt="image" style="height: 50px" class="mr-2 mb-3">
                        @endif

                        <p class="small text-muted mb-0">Title</p>
                        <p class="text-dark">{{ $data->title ?? 'NA' }}</p>

                        <p class="small text-muted mb-0">Category</p>
                        <p class="text-dark">
                            @if ($data->categoryDetails)
                                {{ $data->categoryDetails->title }}
                            @else
                                NA
                            @endif
                        </p>

                        <p class="small text-muted mb-0">Sub-Category</p>
                        <p class="text-dark">
                            @if ($data->subCategoryDetails)
                                {{ $data->subCategoryDetails->title }}
                            @else
                                NA
                            @endif
                        </p>

                        <p class="small text-muted mb-0">Short Description</p>
                        <p class="text-dark">
                            @if (!empty($data->short_desc))
                                {!! nl2br($data->short_desc) !!}
                            @else
                                NA
                            @endif
                        </p>

                        <p class="small text-muted mb-0">Long Description</p>
                        @if ($data->long_desc)
                            <div class="ck-content">{!! $data->long_desc !!}</div>
                        @else
                            <p class="text-dark">NA</p>
                        @endif

                        <hr>

                        <p class="small text-muted mb-0">Page title</p>
                        @if ($data->page_title)
                            <p class="text-dark">{{ nl2br($data->page_title) }}</p>
                        @else
                            <p class="text-dark">NA</p>
                        @endif

                        <p class="small text-muted mb-0">Meta title</p>
                        @if ($data->meta_title)
                            <p class="text-dark">{{ nl2br($data->meta_title) }}</p>
                        @else
                            <p class="text-dark">NA</p>
                        @endif

                        <p class="small text-muted mb-0">Meta description</p>
                        @if ($data->meta_desc)
                            <p class="text-dark">{{ nl2br($data->meta_desc) }}</p>
                        @else
                            <p class="text-dark">NA</p>
                        @endif

                        <p class="small text-muted mb-0">Meta keyword</p>
                        @if ($data->meta_keyword)
                            <p class="text-dark">{{ nl2br($data->meta_keyword) }}</p>
                        @else
                            <p class="text-dark">NA</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
