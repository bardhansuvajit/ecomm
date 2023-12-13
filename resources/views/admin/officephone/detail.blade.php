@extends('admin.layout.app')
@section('page-title', 'Office phone number detail')

@section('section')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row mb-3">
                            <div class="col-md-12 text-right">
                                <a href="{{ route('admin.office.phone.list.all') }}" class="btn btn-sm btn-primary"> <i class="fa fa-chevron-left"></i> Back</a>

                                <a href="{{ route('admin.office.phone.edit', $data->id) }}" class="btn btn-sm btn-primary"> <i class="fa fa-edit"></i> Edit</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="small text-muted mb-0">Number</p>
                        <p class="text-dark">
                            {{ $data->country_code ? $data->country_code : 'NA' }} 
                            {{ $data->number ? $data->number : 'NA' }}
                        </p>

                        <p class="small text-muted mb-0">Type</p>
                        <p class="text-dark">{{ $data->type ? $data->type : 'NA' }}</p>

                        <p class="small text-muted mb-0">Purpose</p>
                        <p class="text-dark">{{ $data->purpose ? $data->purpose : 'NA' }}</p>

                        <p class="small text-muted mb-0">Purpose description</p>
                        <p class="text-dark">{!! $data->purpose_description ? nl2br($data->purpose_description) : 'NA' !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection