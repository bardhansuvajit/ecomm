@extends('admin.layout.app')
@section('page-title', 'Office information')

@section('section')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row mb-3">
                            <div class="col-md-12 text-right">
                                <a href="{{ route('admin.office.information.edit') }}" class="btn btn-sm btn-primary"> <i class="fa fa-edit"></i> Edit</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="small text-muted mb-0">Full name</p>
                        <p class="text-dark">{{ $data->full_name ? $data->full_name : 'NA' }}</p>

                        <p class="small text-muted mb-0">Pretty name</p>
                        <p class="text-dark">{{ $data->pretty_name ? $data->pretty_name : 'NA' }}</p>

                        <p class="small text-muted mb-0">Short description</p>
                        <p class="text-dark">{!! $data->short_desc ? nl2br($data->short_desc) : 'NA' !!}</p>

                        <p class="small text-muted mb-0">Detailed description</p>
                        <p class="text-dark">{!! $data->detailed_desc ? nl2br($data->detailed_desc) : 'NA' !!}</p>

                        <p class="small text-muted mb-0">Primary logo</p>
                        @if (!empty($data->primary_logo) && file_exists(public_path($data->primary_logo)))
                            <img src="{{ asset($data->primary_logo) }}" class="img-thumbnail mb-3" style="height: 100px">
                        @else
                            <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" style="height: 50px" class="mb-3">
                        @endif

                        <p class="small text-muted mb-0">HQ logo</p>
                        @if (!empty($data->hq_logo) && file_exists(public_path($data->hq_logo)))
                            <img src="{{ asset($data->hq_logo) }}" class="img-thumbnail mb-3" style="height: 100px">
                        @else
                            <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" style="height: 50px" class="mb-3">
                        @endif

                        <p class="small text-muted mb-0">Watermark logo</p>
                        @if (!empty($data->watermark_logo) && file_exists(public_path($data->watermark_logo)))
                            <img src="{{ asset($data->watermark_logo) }}" class="img-thumbnail mb-3" style="height: 100px">
                        @else
                            <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" style="height: 50px" class="mb-3">
                        @endif

                        <p class="small text-muted mb-0">Rectangle logo</p>
                        @if (!empty($data->rectangle_logo) && file_exists(public_path($data->rectangle_logo)))
                            <img src="{{ asset($data->rectangle_logo) }}" class="img-thumbnail mb-3" style="height: 100px">
                        @else
                            <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" style="height: 50px" class="mb-3">
                        @endif

                        <p class="small text-muted mb-0">Square logo</p>
                        @if (!empty($data->square_logo) && file_exists(public_path($data->square_logo)))
                            <img src="{{ asset($data->square_logo) }}" class="img-thumbnail mb-3" style="height: 100px">
                        @else
                            <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" style="height: 50px" class="mb-3">
                        @endif

                        <p class="small text-muted mb-0">Favicon</p>
                        @if (!empty($data->favicon) && file_exists(public_path($data->favicon)))
                            <img src="{{ asset($data->favicon) }}" class="img-thumbnail mb-3" style="height: 100px">
                        @else
                            <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" style="height: 50px" class="mb-3">
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

