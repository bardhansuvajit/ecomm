@extends('admin.layout.app')
@section('page-title', 'Coupon list')

@section('section')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row mb-3">
                            <div class="col-md-12 text-right">
                                <a href="{{ route('admin.coupon.create') }}" class="btn btn-sm btn-primary"> <i class="fa fa-plus"></i> Create</a>
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
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Discount</th>
                                    <th>Max Usage</th>
                                    <th>Interval</th>
                                    <th>Usage</th>
                                    <th style="width: 100px">Action</th>
                                </tr>
                            </thead>
                            <tbody class="sortable" data-position-update-route="{{ route('admin.coupon.position') }}" data-csrf-token="{{ csrf_token() }}">
                                @forelse ($data as $index => $item)
                                    <tr class="single" id="{{ $item->id }}">
                                        <td>{{ $index + $data->firstItem() }}</td>
                                        <td>
                                            <p class="text-muted mb-0">{{ $item->code }}</p>
                                        </td>
                                        <td>
                                            <p class="small text-muted mb-0">{{ $item->name }}</p>
                                        </td>
                                        <td>
                                            @if (!empty($item->couponDiscount) && count($item->couponDiscount) > 0)
                                            @foreach ($item->couponDiscount as $discount)
                                                <p class="text-muted font-weight-bold mb-0">
                                                    {!! $discount->currencyDetails->entity !!} - 
                                                    @if ($discount->discount_type == 1)
                                                        {{ $discount->discount_amount }} OFF
                                                    @else
                                                        {{ $discount->discount_amount }}% OFF
                                                    @endif
                                                </p>
                                            @endforeach
                                        @endif
                                        </td>
                                        <td>
                                            <p class="text-dark mb-0">
                                                <span class="small text-muted">Max usage: </span>
                                                {{ $item->max_no_of_usage }}
                                            </p>
                                            <p class="text-dark mb-0">
                                                <span class="small text-muted">User max usage: </span>
                                                {{ $item->user_max_no_of_usage }}
                                            </p>
                                        </td>
                                        <td>
                                            {!! (date('Y-m-d') > $item->expiry_date) ? '<span class="badge badge-danger">EXPIRED</span>' : '' !!}
                                            {!! (date('Y-m-d') == $item->expiry_date) ? '<span class="badge badge-danger">LAST DAY</span>' : '' !!}

                                            <p class="text-dark mb-1">
                                                {{ h_date_only($item->start_date) }} - 
                                                {{ h_date_only($item->expiry_date) }}
                                            </p>
                                        </td>
                                        <td>
                                            {{ count($item->couponUsageTotal) }}
                                        </td>
                                        <td class="d-flex">
                                            <div class="custom-control custom-switch mt-1" data-bs-toggle="tooltip" title="Toggle status">
                                                <input type="checkbox" class="custom-control-input" id="customSwitch{{$item->id}}" {{ ($item->status == 1) ? 'checked' : '' }} onchange="statusToggle('{{ route('admin.coupon.status', $item->id) }}')">
                                                <label class="custom-control-label" for="customSwitch{{$item->id}}"></label>
                                            </div>

                                            <div class="btn-group">
                                                <a href="{{ route('admin.coupon.detail', $item->id) }}" class="btn btn-sm btn-dark" data-bs-toggle="tooltip" title="View">
                                                    <i class="fa fa-eye"></i>
                                                </a>

                                                <a href="{{ route('admin.coupon.edit', $item->id) }}" class="btn btn-sm btn-dark" data-bs-toggle="tooltip" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>

                                                <a href="{{ route('admin.coupon.delete', $item->id) }}" class="btn btn-sm btn-dark" onclick="return confirm('Are you sure ?')" data-bs-toggle="tooltip" title="Delete">
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