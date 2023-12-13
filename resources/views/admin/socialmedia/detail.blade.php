@extends('admin.layout.app')
@section('page-title', 'Social Media detail')

@section('section')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row mb-3">
                            <div class="col-md-12 text-right">
                                <a href="{{ route('admin.management.socialmedia.list.all') }}" class="btn btn-sm btn-primary"> <i class="fa fa-chevron-left"></i> Back</a>

                                <a href="{{ route('admin.management.socialmedia.edit', $data->id) }}" class="btn btn-sm btn-primary"> <i class="fa fa-edit"></i> Edit</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="small text-muted mb-0">Type</p>
                        <p class="text-dark">{{ $data->type ?? 'NA' }}</p>

                        <p class="small text-muted mb-0">Icon type</p>
                        <p class="text-dark">{{ $data->icon_type ?? 'NA' }}</p>

                        <p class="small text-muted mb-0">Icon class</p>
                        <p class="text-dark"><i class="fab {{ $data->icon_class }}"></i> - {{ $data->icon_class ?? 'NA' }}</p>

                        <p class="small text-muted mb-0">Link</p>
                        @if ($data->link)
                            <p class="text-dark"><a href="{{ $data->link }}" target="_blank" rel="noopener noreferrer">{{ $data->link }}</a></p>
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

