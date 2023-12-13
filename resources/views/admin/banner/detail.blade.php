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
                                        @if (!empty($data->image_small) && file_exists(public_path($data->image_small)))
                                            <img src="{{ asset($data->image_small) }}" alt="image" class="img-thumbnail mb-3" style="height: 100px">
                                        @else
                                            <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" alt="image" style="height: 50px" class="mb-3">
                                        @endif

                                        <p class="small text-muted">Small Thumbnail</p>
                                    </td>
                                    <td>
                                        @if (!empty($data->image_medium) && file_exists(public_path($data->image_medium)))
                                            <img src="{{ asset($data->image_medium) }}" alt="image" class="img-thumbnail mb-3" style="height: 100px">
                                        @else
                                            <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" alt="image" style="height: 50px" class="mb-3">
                                        @endif

                                        <p class="small text-muted">Medium Thumbnail</p>
                                    </td>
                                    <td>
                                        @if (!empty($data->image_large) && file_exists(public_path($data->image_large)))
                                            <img src="{{ asset($data->image_large) }}" alt="image" class="img-thumbnail mb-3" style="height: 100px">
                                        @else
                                            <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" alt="image" style="height: 50px" class="mb-3">
                                        @endif

                                        <p class="small text-muted">Large Thumbnail</p>
                                    </td>
                                    <td>
                                        @if (!empty($data->image_org) && file_exists(public_path($data->image_org)))
                                            <img src="{{ asset($data->image_org) }}" alt="image" class="img-thumbnail mb-3" style="height: 100px">
                                        @else
                                            <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" alt="image" style="height: 50px" class="mb-3">
                                        @endif

                                        <p class="small text-muted">Original Thumbnail</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <p class="small text-muted mb-0">Web link</p>
                        <p class="text-dark">{{ $data->web_link ? $data->web_link : 'NA' }}</p>

                        <p class="small text-muted mb-0">App link</p>
                        <p class="text-dark">{{ $data->app_link ? $data->app_link : 'NA' }}</p>

                        <p class="small text-muted mb-0">Title 1</p>
                        <p class="text-dark">{{ $data->title1 ? $data->title1 : 'NA' }}</p>

                        <p class="small text-muted mb-0">Title 2</p>
                        <p class="text-dark">{{ $data->title2 ? $data->title2 : 'NA' }}</p>

                        <p class="small text-muted mb-0">Short description</p>
                        <p class="text-dark">{!! $data->short_description ? nl2br($data->short_description) : 'NA' !!}</p>

                        <p class="small text-muted mb-0">Detailed description</p>
                        <p class="text-dark">{!! $data->detailed_description ? nl2br($data->detailed_description) : 'NA' !!}</p>

                        <p class="small text-muted mb-0">Button text</p>
                        <p class="text-dark">{{ $data->btn_text ? $data->btn_text : 'NA' }}</p>

                        <p class="small text-muted mb-0">Button link</p>
                        <p class="text-dark">{{ $data->btn_link ? $data->btn_link : 'NA' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
