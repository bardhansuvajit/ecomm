@extends('admin.layout.app')
@section('page-title', 'Category '.$level.' list')

@section('section')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row mb-3">
                            <div class="col-md-12 text-right">
                                <a href="{{ route('admin.product.category.create', $level) }}" class="btn btn-sm btn-primary"> <i class="fa fa-plus"></i> Create</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6"></div>
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
                                                <a href="{{ url()->current() }}" class="btn btn-sm btn-light" data-toggle="tooltip" title="Clear filter">
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
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Title</th>
                                    <th>Highlight</th>
                                    <th>Products</th>
                                    <th style="width: 100px">Action</th>
                                </tr>
                            </thead>
                            <tbody class="sortable" data-position-update-route="{{ route('admin.product.category.position', $level) }}" data-csrf-token="{{ csrf_token() }}">
                                @forelse ($data as $index => $item)
                                    <tr class="single" id="{{ $item->id }}">
                                        <td>{{ $index + $data->firstItem() }}</td>
                                        <td>
                                            @if ($item->icon_small)
                                                <img src="{{ asset($item->icon_small) }}" alt="" height="50">
                                            @endif

                                            {{ $item->title }}

                                            @if ($level != 1)
                                                @if ($item->parentDetail)
                                                    <p class="small text-muted mb-2">
                                                        Parent: 
                                                        <a href="">{{ $item->parentDetail->title }}</a>
                                                    </p>
                                                @else
                                                    <p class="text-danger font-weight-bold mb-2" title="Parent might be deleted">Missing Parent</p>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            {{-- <a href="{{ route('admin.product.category.highlight., $levellist.all', $item->id) }}" class="btn btn-sm btn-primary">Visit</a> --}}
                                        </td>
                                        <td>
                                            {{ $item->productsDetails->count() }}
                                        </td>
                                        <td class="d-flex">
                                            <div class="custom-control custom-switch mt-1" data-toggle="tooltip" title="Toggle status">
                                                <input type="checkbox" class="custom-control-input" id="customSwitch{{$item->id}}" {{ ($item->status == 1) ? 'checked' : '' }} onchange="statusToggle('{{ route('admin.product.category.status', [$level, $item->id]) }}')">
                                                <label class="custom-control-label" for="customSwitch{{$item->id}}"></label>
                                            </div>

                                            <div class="btn-group">
                                                <a href="{{ route('admin.product.category.detail', [$level, $item->id]) }}" class="btn btn-sm btn-dark" data-toggle="tooltip" title="View">
                                                    <i class="fa fa-eye"></i>
                                                </a>

                                                <a href="{{ route('admin.product.category.edit', [$level, $item->id]) }}" class="btn btn-sm btn-dark" data-toggle="tooltip" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>

                                                <a href="{{ route('admin.product.category.delete', [$level, $item->id]) }}" class="btn btn-sm btn-dark" onclick="return confirm('Are you sure ?')" data-toggle="tooltip" title="Delete">
                                                    <i class="fa fa-trash"></i>
                                                </a>
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