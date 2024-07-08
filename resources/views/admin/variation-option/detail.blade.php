@extends('admin.layout.app')
@section('page-title', 'Variation option detail')

@section('section')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row mb-3">
                            <div class="col-md-12 text-right">
                                <a href="{{ route('admin.product.variation.option.list') }}" class="btn btn-sm btn-primary"> <i class="fa fa-chevron-left"></i> Back</a>

                                <a href="{{ route('admin.product.variation.option.edit', $data->id) }}" class="btn btn-sm btn-primary"> <i class="fa fa-edit"></i> Edit</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <p class="small text-muted mb-0">Title</p>
                        <p class="{{ $data->title ? 'text-dark' : 'text-danger font-weight-bold' }}">
                            {{ $data->title ?? 'NA' }}
                        </p>

                        <p class="small text-muted mb-0">Short Description</p>
                        <p class="{{ $data->short_description ? 'text-dark' : 'text-danger font-weight-bold' }}">
                            {!! $data->short_description ? nl2br(e($data->short_description)) : 'NA' !!}
                        </p>

                        <p class="small text-muted mb-0">Long Description</p>
                        <p class="{{ $data->long_description ? 'text-dark' : 'text-danger font-weight-bold' }}">
                            {!! $data->long_description ? nl2br(e($data->long_description)) : 'NA' !!}
                        </p>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

