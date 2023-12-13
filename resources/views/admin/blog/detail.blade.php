@extends('admin.layout.app')
@section('page-title', 'Blog detail')

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
                                <a href="{{ route('admin.blog.list.all') }}" class="btn btn-sm btn-primary"> <i class="fa fa-chevron-left"></i> Back</a>

                                <a href="{{ route('admin.blog.list.edit', $data->id) }}" class="btn btn-sm btn-primary"> <i class="fa fa-edit"></i> Edit</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="font-weight-bold text-primary">Image</h5>
                        <table class="table table-sm mb-4">
                            <tbody>
                                <tr>
                                    <td>
                                        @if (!empty($data->image_small) && file_exists(public_path($data->image_small)))
                                            <img src="{{ asset($data->image_small) }}" alt="image" class="img-thumbnail mb-3" style="height: 100px">
                                        @else
                                            <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" alt="image" style="height: 50px" class="mb-3">
                                        @endif

                                        <p class="small text-muted">Image Small</p>
                                    </td>
                                    <td>
                                        @if (!empty($data->image_medium) && file_exists(public_path($data->image_medium)))
                                            <img src="{{ asset($data->image_medium) }}" alt="image" class="img-thumbnail mb-3" style="height: 100px">
                                        @else
                                            <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" alt="image" style="height: 50px" class="mb-3">
                                        @endif

                                        <p class="small text-muted">Image Medium</p>
                                    </td>
                                    <td>
                                        @if (!empty($data->image_large) && file_exists(public_path($data->image_large)))
                                            <img src="{{ asset($data->image_large) }}" alt="image" class="img-thumbnail mb-3" style="height: 100px">
                                        @else
                                            <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" alt="image" style="height: 50px" class="mb-3">
                                        @endif

                                        <p class="small text-muted">Image Large</p>
                                    </td>
                                    <td>
                                        @if (!empty($data->image_org) && file_exists(public_path($data->image_org)))
                                            <img src="{{ asset($data->image_org) }}" alt="image" class="img-thumbnail mb-3" style="height: 100px">
                                        @else
                                            <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" alt="image" style="height: 50px" class="mb-3">
                                        @endif

                                        <p class="small text-muted">Image Original</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <hr>

                        <h5 class="font-weight-bold text-primary">Category &amp; tags</h5>
                        <p class="small text-muted mb-0">Category 1</p>
                        @if (!empty(category1DetailsAdmin($data->id)))
                            <p class="text-dark">{!! category1DetailsAdmin($data->id) !!}</p>
                        @else
                            <p class="text-danger font-weight-bold">NA</p>
                        @endif

                        <p class="small text-muted mb-0">Category 2</p>
                        @if (!empty(category2DetailsAdmin($data->id)))
                            <p class="text-dark">{!! category2DetailsAdmin($data->id) !!}</p>
                        @else
                            <p class="text-danger font-weight-bold">NA</p>
                        @endif

                        <p class="small text-muted mb-0">Tags</p>
                        @if (!empty($data->tagDetails) && count($data->tagDetails) > 0)
                            @foreach ($data->tagDetails as $tagSetup)
                                <a href="{{ route('admin.blog.tag.detail', $tagSetup->tagDetail->id) }}">{{ $tagSetup->tagDetail->title }}</a>
                            @endforeach
                            {{-- <p class="text-dark">{!! category2DetailsAdmin($data->id) !!}</p> --}}
                        @else
                            <p class="text-danger font-weight-bold">NA</p>
                        @endif

                        <hr>

                        <h5 class="font-weight-bold text-primary">Title &amp; Description</h5>
                        <p class="small text-muted mb-0">Title</p>
                        @if ($data->title)
                            <p class="text-dark">{{ $data->title }}</p>
                        @else
                            <p class="text-danger font-weight-bold">NA</p>
                        @endif

                        <p class="small text-muted mb-0">Short Description</p>
                        @if ($data->short_desc)
                            <p class="text-dark">{!! nl2br($data->short_desc) !!}</p>
                        @else
                            <p class="text-danger font-weight-bold">NA</p>
                        @endif

                        <p class="small text-muted mb-0">Detailed Description</p>
                        @if ($data->detailed_desc)
                            <div class="ck-content">{!! $data->detailed_desc !!}</div>
                        @else
                            <p class="text-danger font-weight-bold">NA</p>
                        @endif

                        <hr>

                        <h5 class="font-weight-bold text-primary">SEO</h5>
                        <p class="small text-muted mb-0">Page title</p>
                        @if ($data->page_title)
                            <p class="text-dark">{!! nl2br($data->page_title) !!}</p>
                        @else
                            <p class="text-danger font-weight-bold">NA</p>
                        @endif

                        <p class="small text-muted mb-0">Meta title</p>
                        @if ($data->meta_title)
                            <p class="text-dark">{!! nl2br($data->meta_title) !!}</p>
                        @else
                            <p class="text-danger font-weight-bold">NA</p>
                        @endif

                        <p class="small text-muted mb-0">Meta description</p>
                        @if ($data->meta_desc)
                            <p class="text-dark">{!! nl2br($data->meta_desc) !!}</p>
                        @else
                            <p class="text-danger font-weight-bold">NA</p>
                        @endif

                        <p class="small text-muted mb-0">Meta keyword</p>
                        @if ($data->meta_keyword)
                            <p class="text-dark">{!! nl2br($data->meta_keyword) !!}</p>
                        @else
                            <p class="text-danger font-weight-bold">NA</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
