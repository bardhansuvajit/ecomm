@extends('admin.layout.app')
@section('page-title', 'Review')

@section('section')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row mb-3">
                            <div class="col-md-12 text-right">
                                <a href="{{ route('admin.review.create') }}" class="btn btn-sm btn-primary"> <i class="fa fa-plus"></i> Create</a>
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
                                            <select name="product" id="product" class="form-select form-select-sm" style="width: 150px;">
                                                <option value="">Select product...</option>
                                                @foreach ($activeProducts['data'] as $product)
                                                    <option value="{{ $product->id }}" {{ (request()->input('product') == $product->id) ? 'selected' : '' }}>{{ $product->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
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
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-hover mb-3">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th style="width: 200px">Product</th>
                                    <th style="width: 100px">User</th>
                                    <th>Rating</th>
                                    <th>Review</th>
                                    <th>Datetime</th>
                                    <th style="width: 100px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $index => $item)
                                    <tr>
                                        <td>{{ $index + $data->firstItem() }}</td>
                                        <td>
                                            @if ($item->productDetails)
                                                <div class="d-flex mb-3">
                                                    <div class="image-holder mr-3">
                                                        <a href="{{ route('admin.product.detail', $item->productDetails->id) }}">
                                                        @if (
                                                            (count($item->productDetails->frontImageDetails) > 0) && 
                                                            file_exists($item->productDetails->frontImageDetails[0]->img_medium)
                                                            )
                                                            <img src="{{ asset($item->productDetails->frontImageDetails[0]->img_medium) }}" style="width:50px">
                                                        @else
                                                            <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" style="width:50px">
                                                        @endif
                                                        </a>
                                                    </div>
                                                    <div class="other-details">
                                                        @if ($item->productDetails->title)
                                                            <p class="small text-muted mb-1"><a href="{{ route('admin.product.detail', $item->productDetails->id) }}">{{ $item->productDetails->title }}</a></p>
                                                        @endif
                                                        <small>{!! productCategories($item->productDetails->id, 1, 'horizontal') !!}</small>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->guest_review == 1)
                                                <p class="small text-muted mb-0">{{ $item->name }}</p>
                                            @else
                                                @if ($item->userDetails)
                                                    <p class="small text-muted mb-0">
                                                        <a href="">{{ $item->userDetails->first_name.' '.$item->userDetails->last_name }}</a>
                                                    </p>
                                                @endif
                                            @endif
                                            <p class="small text-muted mb-0">
                                                @if ($item->email)<i class="fas fa-envelope"></i> {{ $item->email }}@endif
                                            </p>
                                            <p class="small text-muted mb-0">
                                                @if ($item->phone_number)<i class="fas fa-phone fa-rotate-90"></i> {{ $item->phone_number }}@endif
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-{{ bootstrapRatingTypeColor($item->rating) }} mb-0">{{ $item->rating }} <i class="fas fa-star"></i> </p>
                                        </td>
                                        <td>
                                            <p class="small mb-1">{{ $item->heading }}</p>
                                            <p class="small text-muted mb-0">{{ $item->review }}</p>
                                        </td>
                                        <td>
                                            <p class="small text-muted">
                                                {{ h_date($item->created_at) }}
                                            </p>
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                <div class="custom-control custom-switch mt-1" data-toggle="tooltip" title="Toggle status">
                                                    <input type="checkbox" class="custom-control-input" id="customSwitch{{$item->id}}" {{ ($item->status == 1) ? 'checked' : '' }} onchange="statusToggle('{{ route('admin.review.status', $item->id) }}')">
                                                    <label class="custom-control-label" for="customSwitch{{$item->id}}"></label>
                                                </div>

                                                <div class="btn-group">
                                                    <a href="{{ route('admin.review.detail', $item->id) }}" class="btn btn-sm btn-dark" data-toggle="tooltip" title="View">
                                                        <i class="fa fa-eye"></i>
                                                    </a>

                                                    <a href="{{ route('admin.review.edit', $item->id) }}" class="btn btn-sm btn-dark" data-toggle="tooltip" title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </a>

                                                    <a href="{{ route('admin.review.delete', $item->id) }}" class="btn btn-sm btn-dark" onclick="return confirm('Are you sure ?')" data-toggle="tooltip" title="Delete">
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