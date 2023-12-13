@extends('admin.layout.app')
@section('page-title', 'Partner detail')

@section('section')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row mb-3">
                            <div class="col-md-12 text-right">
                                <a href="{{ route('admin.management.partner.list.all') }}" class="btn btn-sm btn-primary"> <i class="fa fa-chevron-left"></i> Back</a>

                                <a href="{{ route('admin.management.partner.edit', $data->id) }}" class="btn btn-sm btn-primary"> <i class="fa fa-edit"></i> Edit</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="small text-muted mb-0">Image</p>
                        @if (!empty($data->img_large) && file_exists(public_path($data->img_large)))
                            <img src="{{ asset($data->img_large) }}" alt="image" class="img-thumbnail mb-3" style="height: 100px">
                        @else
                            <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" alt="image" style="height: 50px" class="mb-3">
                        @endif

                        <p class="small text-muted mb-0">Name</p>
                        <p class="text-dark">{{ $data->name ?? 'NA' }}</p>

                        <p class="small text-muted mb-0">Description</p>
                        <p class="text-dark">{{ $data->description ?? 'NA' }}</p>

                        {{-- <p class="small text-muted mb-0">Button Text</p>
                        <p class="text-dark">{{ $data->btn_text ?? 'NA' }}</p>

                        <p class="small text-muted mb-0">Button Link</p>
                        @if ($data->btn_link)
                            <p class="text-dark"><a href="{{ $data->btn_link }}" target="_blank" rel="noopener noreferrer">{{ $data->btn_link }}</a></p>
                        @else
                            <p class="text-dark">NA</p>
                        @endif --}}

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

