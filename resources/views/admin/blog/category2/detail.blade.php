@extends('admin.layout.app')
@section('page-title', 'Blog detail')

@section('section')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row mb-3">
                            <div class="col-md-12 text-right">
                                <a href="{{ route('admin.blog.category2.list.all') }}" class="btn btn-sm btn-primary"> <i class="fa fa-chevron-left"></i> Back</a>

                                <a href="{{ route('admin.blog.category2.edit', $data->id) }}" class="btn btn-sm btn-primary"> <i class="fa fa-edit"></i> Edit</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="font-weight-bold text-primary">Icon &amp; Banner</h5>
                        <table class="table table-sm mb-4">
                            <tbody>
                                <tr>
                                    <td>
                                        @if (!empty($data->icon_small) && file_exists(public_path($data->icon_small)))
                                            <img src="{{ asset($data->icon_small) }}" alt="image" class="img-thumbnail mb-3" style="height: 100px">
                                        @else
                                            <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" alt="image" style="height: 50px" class="mb-3">
                                        @endif

                                        <p class="small text-muted">Icon Small</p>
                                    </td>
                                    <td>
                                        @if (!empty($data->icon_medium) && file_exists(public_path($data->icon_medium)))
                                            <img src="{{ asset($data->icon_medium) }}" alt="image" class="img-thumbnail mb-3" style="height: 100px">
                                        @else
                                            <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" alt="image" style="height: 50px" class="mb-3">
                                        @endif

                                        <p class="small text-muted">Icon Medium</p>
                                    </td>
                                    <td>
                                        @if (!empty($data->icon_large) && file_exists(public_path($data->icon_large)))
                                            <img src="{{ asset($data->icon_large) }}" alt="image" class="img-thumbnail mb-3" style="height: 100px">
                                        @else
                                            <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" alt="image" style="height: 50px" class="mb-3">
                                        @endif

                                        <p class="small text-muted">Icon Large</p>
                                    </td>
                                    <td>
                                        @if (!empty($data->icon_org) && file_exists(public_path($data->icon_org)))
                                            <img src="{{ asset($data->icon_org) }}" alt="image" class="img-thumbnail mb-3" style="height: 100px">
                                        @else
                                            <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" alt="image" style="height: 50px" class="mb-3">
                                        @endif

                                        <p class="small text-muted">Icon Original</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="table table-sm mb-4">
                            <tbody>
                                <tr>
                                    <td>
                                        @if (!empty($data->banner_small) && file_exists(public_path($data->banner_small)))
                                            <img src="{{ asset($data->banner_small) }}" alt="image" class="img-thumbnail mb-3" style="height: 100px">
                                        @else
                                            <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" alt="image" style="height: 50px" class="mb-3">
                                        @endif

                                        <p class="small text-muted">Banner Small</p>
                                    </td>
                                    <td>
                                        @if (!empty($data->banner_medium) && file_exists(public_path($data->banner_medium)))
                                            <img src="{{ asset($data->banner_medium) }}" alt="image" class="img-thumbnail mb-3" style="height: 100px">
                                        @else
                                            <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" alt="image" style="height: 50px" class="mb-3">
                                        @endif

                                        <p class="small text-muted">Banner Medium</p>
                                    </td>
                                    <td>
                                        @if (!empty($data->banner_large) && file_exists(public_path($data->banner_large)))
                                            <img src="{{ asset($data->banner_large) }}" alt="image" class="img-thumbnail mb-3" style="height: 100px">
                                        @else
                                            <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" alt="image" style="height: 50px" class="mb-3">
                                        @endif

                                        <p class="small text-muted">Banner Large</p>
                                    </td>
                                    <td>
                                        @if (!empty($data->banner_org) && file_exists(public_path($data->banner_org)))
                                            <img src="{{ asset($data->banner_org) }}" alt="image" class="img-thumbnail mb-3" style="height: 100px">
                                        @else
                                            <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" alt="image" style="height: 50px" class="mb-3">
                                        @endif

                                        <p class="small text-muted">Banner Original</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <h5 class="font-weight-bold text-primary">Title &amp; Description</h5>
                        <p class="small text-muted mb-0">Category</p>
                        @if ($data->category1Details)
                            <p class="text-dark">{{ $data->category1Details->title }}</p>
                        @else
                            <p class="text-danger font-weight-bold">NA</p>
                        @endif

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
                            <p class="text-dark">{!! nl2br($data->detailed_desc) !!}</p>
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
