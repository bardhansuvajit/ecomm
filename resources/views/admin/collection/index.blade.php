@extends('admin.layout.app')
@section('page-title', 'Collection list')

@section('section')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row mb-3">
                            <div class="col-md-12 text-right">
                                <a href="{{ route('admin.product.collection.create') }}" class="btn btn-sm btn-primary"> <i class="fa fa-plus"></i> Create</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="small text-muted font-weight-bold">Showing {{$data->firstItem()}}-{{$data->lastItem()}} out of {{$data->total()}}</p>
                            </div>
                            <div class="col-md-6">
                                <form action="" method="get">
                                    <div class="d-flex justify-content-end">
                                        <div class="form-group ml-2">
                                            <input type="search" class="form-control form-control-sm" name="keyword" id="keyword" value="{{ request()->input('keyword') }}" placeholder="Search something...">
                                        </div>

                                        <div class="form-group ml-2">
                                            <div class="btn-group">
                                                <button type="submit" class="btn btn-sm btn-primary">
                                                    <i class="fa fa-filter"></i>
                                                </button>
                                                <a href="{{ url()->current() }}" class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="Clear filter">
                                                    <i class="fa fa-times"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <p class="small text-muted text-right">Drag &amp; drop table content to re-order their position</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-hover mb-3">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Title</th>
                                    <th>Products</th>
                                    <th style="width: 100px">Action</th>
                                </tr>
                            </thead>
                            <tbody class="sortable" data-position-update-route="{{ route('admin.product.collection.position') }}" data-csrf-token="{{ csrf_token() }}">
                                @forelse ($data as $index => $item)
                                    <tr class="single" id="{{ $item->id }}">
                                        <td>{{ $index + $data->firstItem() }}</td>
                                        <td>
                                            @if ($item->icon_small)
                                                <img src="{{ asset($item->icon_small) }}" alt="" height="50">
                                            @endif

                                            {{ $item->title }}
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.product.collection.detail', $item->id) }}">
                                                {{ count($item->productsDetails) }}
                                            </a>
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                <div class="custom-control custom-switch mt-1" data-bs-toggle="tooltip" title="Toggle status">
                                                    <input type="checkbox" class="custom-control-input" id="customSwitch{{$item->id}}" {{ ($item->status == 1) ? 'checked' : '' }} onchange="statusToggle('{{ route('admin.product.collection.status', $item->id) }}')">
                                                    <label class="custom-control-label" for="customSwitch{{$item->id}}"></label>
                                                </div>
    
                                                <div class="btn-group">
                                                    <a href="{{ route('admin.product.collection.detail', $item->id) }}" class="btn btn-sm btn-dark" data-bs-toggle="tooltip" title="View">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
    
                                                    <a href="{{ route('admin.product.collection.edit', $item->id) }}" class="btn btn-sm btn-dark" data-bs-toggle="tooltip" title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
    
                                                    <a href="{{ route('admin.product.collection.delete', $item->id) }}" class="btn btn-sm btn-dark" onclick="return confirm('Are you sure ?')" data-bs-toggle="tooltip" title="Delete">
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

                        <div class="pagination-container">
                            {{$data->appends($_GET)->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection