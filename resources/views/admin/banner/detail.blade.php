@extends('admin.layout.app')
@section('page-title', 'Banner detail')

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

                                <a href="{{ route('admin.content.banner.edit', $data->id) }}" class="btn btn-sm btn-primary"> <i class="fa fa-edit"></i> Edit</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm mb-4">
                            <tbody>
                                <tr>
                                    <td>
                                        @if (!empty($data->desktop_image_small) && file_exists(public_path($data->desktop_image_small)))
                                            <img src="{{ asset($data->desktop_image_small) }}" alt="image" class="img-thumbnail mb-3" style="height: 100px">
                                        @else
                                            <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" alt="image" style="height: 50px" class="mb-3">
                                        @endif

                                        <p class="small text-muted">Desktop Small Thumbnail</p>
                                    </td>
                                    <td>
                                        @if (!empty($data->desktop_image_medium) && file_exists(public_path($data->desktop_image_medium)))
                                            <img src="{{ asset($data->desktop_image_medium) }}" alt="image" class="img-thumbnail mb-3" style="height: 100px">
                                        @else
                                            <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" alt="image" style="height: 50px" class="mb-3">
                                        @endif

                                        <p class="small text-muted">Desktop Medium Thumbnail</p>
                                    </td>
                                    <td>
                                        @if (!empty($data->desktop_image_large) && file_exists(public_path($data->desktop_image_large)))
                                            <img src="{{ asset($data->desktop_image_large) }}" alt="image" class="img-thumbnail mb-3" style="height: 100px">
                                        @else
                                            <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" alt="image" style="height: 50px" class="mb-3">
                                        @endif

                                        <p class="small text-muted">Desktop Large Thumbnail</p>
                                    </td>
                                    <td>
                                        @if (!empty($data->desktop_image_org) && file_exists(public_path($data->desktop_image_org)))
                                            <img src="{{ asset($data->desktop_image_org) }}" alt="image" class="img-thumbnail mb-3" style="height: 100px">
                                        @else
                                            <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" alt="image" style="height: 50px" class="mb-3">
                                        @endif

                                        <p class="small text-muted">Desktop Original Thumbnail</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="table table-sm mb-4">
                            <tbody>
                                <tr>
                                    <td>
                                        @if (!empty($data->mobile_image_small) && file_exists(public_path($data->mobile_image_small)))
                                            <img src="{{ asset($data->mobile_image_small) }}" alt="image" class="img-thumbnail mb-3" style="height: 100px">
                                        @else
                                            <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" alt="image" style="height: 50px" class="mb-3">
                                        @endif

                                        <p class="small text-muted">Mobile Small Thumbnail</p>
                                    </td>
                                    <td>
                                        @if (!empty($data->mobile_image_medium) && file_exists(public_path($data->mobile_image_medium)))
                                            <img src="{{ asset($data->mobile_image_medium) }}" alt="image" class="img-thumbnail mb-3" style="height: 100px">
                                        @else
                                            <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" alt="image" style="height: 50px" class="mb-3">
                                        @endif

                                        <p class="small text-muted">Mobile Medium Thumbnail</p>
                                    </td>
                                    <td>
                                        @if (!empty($data->mobile_image_large) && file_exists(public_path($data->mobile_image_large)))
                                            <img src="{{ asset($data->mobile_image_large) }}" alt="image" class="img-thumbnail mb-3" style="height: 100px">
                                        @else
                                            <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" alt="image" style="height: 50px" class="mb-3">
                                        @endif

                                        <p class="small text-muted">Mobile Large Thumbnail</p>
                                    </td>
                                    <td>
                                        @if (!empty($data->mobile_image_org) && file_exists(public_path($data->mobile_image_org)))
                                            <img src="{{ asset($data->mobile_image_org) }}" alt="image" class="img-thumbnail mb-3" style="height: 100px">
                                        @else
                                            <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" alt="image" style="height: 50px" class="mb-3">
                                        @endif

                                        <p class="small text-muted">Mobile Original Thumbnail</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <p class="small text-muted mb-0">Web link</p>
                        @if ($data->web_link)
                            <p class="text-dark">{{ $data->web_link }}</p>
                        @else
                            <p class="text-danger font-weight-bold">NA</p>
                        @endif

                        <p class="small text-muted mb-0">App link</p>
                        @if ($data->app_link)
                            <p class="text-dark">{{ $data->app_link }}</p>
                        @else
                            <p class="text-danger font-weight-bold">NA</p>
                        @endif

                        <p class="small text-muted mb-0">Title 1</p>
                        @if ($data->title1)
                            <p class="text-dark">{{ $data->title1 }}</p>
                        @else
                            <p class="text-danger font-weight-bold">NA</p>
                        @endif

                        <p class="small text-muted mb-0">Title 2</p>
                        @if ($data->title2)
                            <p class="text-dark">{{ $data->title2 }}</p>
                        @else
                            <p class="text-danger font-weight-bold">NA</p>
                        @endif

                        <p class="small text-muted mb-0">Short description</p>
                        @if ($data->short_description)
                            <p class="text-dark">{!! nl2br($data->short_description) !!}</p>
                        @else
                            <p class="text-danger font-weight-bold">NA</p>
                        @endif

                        <p class="small text-muted mb-0">Detailed description</p>
                        @if ($data->detailed_description)
                            <p class="text-dark">{!! nl2br($data->detailed_description) !!}</p>
                        @else
                            <p class="text-danger font-weight-bold">NA</p>
                        @endif

                        <p class="small text-muted mb-0">Button text</p>
                        @if ($data->btn_text)
                            <p class="text-dark">{{ $data->btn_text }}</p>
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
