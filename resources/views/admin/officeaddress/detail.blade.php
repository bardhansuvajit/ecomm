@extends('admin.layout.app')
@section('page-title', 'Office address detail')

@section('section')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row mb-3">
                            <div class="col-md-12 text-right">
                                <a href="{{ route('admin.office.address.list.all') }}" class="btn btn-sm btn-primary"> <i class="fa fa-chevron-left"></i> Back</a>

                                <a href="{{ route('admin.office.address.edit', $data->id) }}" class="btn btn-sm btn-primary"> <i class="fa fa-edit"></i> Edit</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="small text-muted mb-0">Type</p>
                        <p class="text-dark">{{ $data->type ? $data->type : 'NA' }}</p>

                        <p class="small text-muted mb-0">Title</p>
                        <p class="text-dark">{{ $data->title ? $data->title : 'NA' }}</p>

                        <p class="small text-muted mb-0">Street address</p>
                        <p class="text-dark">{{ $data->street_address ? $data->street_address : 'NA' }}</p>

                        <p class="small text-muted mb-0">Pincode</p>
                        <p class="text-dark">{{ $data->pincode ? $data->pincode : 'NA' }}</p>

                        <p class="small text-muted mb-0">State</p>
                        <p class="text-dark">{{ $data->state ? $data->state : 'NA' }}</p>

                        <p class="small text-muted mb-0">Country</p>
                        <p class="text-dark">{{ $data->country ? $data->country : 'NA' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

