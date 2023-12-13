@extends('admin.layout.app')
@section('page-title', 'Testimonial detail')

@section('section')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row mb-3">
                            <div class="col-md-12 text-right">
                                <a href="{{ route('admin.management.testimonial.list.all') }}" class="btn btn-sm btn-primary"> <i class="fa fa-chevron-left"></i> Back</a>

                                <a href="{{ route('admin.management.testimonial.edit', $data->id) }}" class="btn btn-sm btn-primary"> <i class="fa fa-edit"></i> Edit</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="small text-muted mb-0">Image</p>
                        @if (!empty($data->image_small) && file_exists(public_path($data->image_small)))
                            <img src="{{ asset($data->image_small) }}" alt="image" class="img-thumbnail mb-3" style="height: 100px">
                        @else
                            <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" alt="image" style="height: 50px" class="mb-3">
                        @endif

                        <p class="small text-muted mb-0">Name</p>
                        <p class="text-dark">{{ $data->name ?? 'NA' }}</p>

                        <p class="small text-muted mb-0">Designation</p>
                        <p class="text-dark">{{ $data->designation ?? 'NA' }}</p>

                        <p class="small text-muted mb-0">Comment</p>
                        <p class="text-dark">{{ $data->comment ?? 'NA' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

