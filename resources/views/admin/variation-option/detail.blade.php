@extends('admin.layout.app')
@section('page-title', 'Variation detail')

@section('section')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row mb-3">
                            <div class="col-md-12 text-right">
                                <a href="{{ route('admin.product.variation.list') }}" class="btn btn-sm btn-primary"> <i class="fa fa-chevron-left"></i> Back</a>

                                <a href="{{ route('admin.product.variation.edit', $data->id) }}" class="btn btn-sm btn-primary"> <i class="fa fa-edit"></i> Edit</a>
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

                        <p class="small text-muted mb-0">Options</p>
                        <table class="table table-sm table-hover mb-3">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Equivalent</th>
                                    <th>Information</th>
                                    <th>Datetime</th>
                                    <th style="width: 100px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data->options as $index => $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>
                                            <p class="">{{ $item->value }}</p>
                                        </td>
                                        <td>
                                            <p class="">{{ $item->category }}</p>
                                        </td>
                                        <td>
                                            <p class="">{{ $item->equivalent }}</p>
                                        </td>
                                        <td>
                                            <p class="">{{ $item->information }}</p>
                                        </td>
                                        <td>
                                            <p class="small text-muted">
                                                {{ h_date($item->created_at) }}
                                            </p>
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                <div class="custom-control custom-switch mt-1" data-toggle="tooltip" title="Toggle status">
                                                    <input type="checkbox" class="custom-control-input" id="customSwitch{{$item->id}}" {{ ($item->status == 1) ? 'checked' : '' }} onchange="statusToggle('{{ route('admin.product.variation.status', $item->id) }}')">
                                                    <label class="custom-control-label" for="customSwitch{{$item->id}}"></label>
                                                </div>

                                                <div class="btn-group">
                                                    <a href="{{ route('admin.product.variation.detail', $item->id) }}" class="btn btn-sm btn-dark" data-toggle="tooltip" title="View">
                                                        <i class="fa fa-eye"></i>
                                                    </a>

                                                    <a href="{{ route('admin.product.variation.edit', $item->id) }}" class="btn btn-sm btn-dark" data-toggle="tooltip" title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </a>

                                                    <a href="{{ route('admin.product.variation.delete', $item->id) }}" class="btn btn-sm btn-dark" onclick="return confirm('Are you sure ?')" data-toggle="tooltip" title="Delete">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="100%" class="text-center">No records found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

