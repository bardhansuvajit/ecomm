@extends('admin.layout.app')
@section('page-title', 'Order list')

@section('section')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row mb-3">
                            <div class="col-md-12 text-right">
                                {{-- <a href="{{ route('admin.order.create') }}" class="btn btn-sm btn-primary"> <i class="fa fa-plus"></i> Create offline order</a> --}}
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
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-hover mb-3">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>No</th>
                                    <th>Customer</th>
                                    <th>Payment</th>
                                    <th>Shipping Address</th>
                                    <th>Products</th>
                                    <th style="width: 100px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $index => $item)
                                    <tr>
                                        <td>{{ $index + $data->firstItem() }}</td>
                                        <td>{{ $item->order_no }}</td>
                                        <td>
                                            @if ($item->user_id == 0)
                                                <div class="badge badge-danger rounded-0">Guest user</div>
                                            @endif
                                            <p class="mb-1">{{ $item->user_full_name }}</p>
                                            <p class="mb-1">{{ $item->user_email }}</p>
                                            <p class="mb-1">{{ $item->user_phone_no }}</p>
                                        </td>
                                        <td>
                                            <p class="text-primary font-weight-bold mb-1">
                                                {!! $item->orderProducts[0]->currency_entity !!}
                                                {{ $item->final_order_amount }}
                                            </p>
                                            <p class="font-weight-bold mb-0">
                                                {{ $item->payment_method }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="mb-1">
                                                {{ $item->addressDetails->shipping_address_country }}, 
                                                {{ $item->addressDetails->shipping_address_postcode }}, 
                                                {{ $item->addressDetails->shipping_address_state }}, 
                                                {{ $item->addressDetails->shipping_address_city }}
                                            </p>
                                        </td>
                                        <td>
                                            <div class="product-container">
                                                @foreach ($item->orderProducts as $product)
                                                    <div class="single-product mr-3">
                                                        <div class="img-holder">
                                                            @if (!empty($product->product_image) && file_exists(public_path($product->product_image)))
                                                                <img src="{{ asset($product->product_image) }}" alt="image">
                                                            @else
                                                                <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" alt="image">
                                                            @endif
                                                        </div>
                                                        <div class="details">
                                                            <p class="small mb-0">{{ $product->product_title }}</p>
                                                            <p class="small mb-1">{{ $product->variation_info }}</p>
                                                            <p class="text-dark">
                                                                <span class="small text-muted">Qty: </span>
                                                                <span class="font-weight-bold">{{ $product->qty }}</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </td>

                                        <td>
                                            <div class="d-flex">
                                                {{-- <div class="custom-control custom-switch mt-1" data-bs-toggle="tooltip" title="Toggle status">
                                                    <input type="checkbox" class="custom-control-input" id="customSwitch{{$item->id}}" {{ ($item->status == 1) ? 'checked' : '' }} onchange="statusToggle('{{ route('admin.category.status', $item->id) }}')">
                                                    <label class="custom-control-label" for="customSwitch{{$item->id}}"></label>
                                                </div> --}}

                                                <div class="btn-group">
                                                    <a href="{{ route('admin.order.detail', $item->id) }}" class="btn btn-sm btn-dark" data-bs-toggle="tooltip" title="View">
                                                        <i class="fa fa-eye"></i>
                                                    </a>

                                                    {{-- <a href="{{ route('admin.category.edit', $item->id) }}" class="btn btn-sm btn-dark" data-bs-toggle="tooltip" title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </a> --}}

                                                    {{-- <a href="{{ route('admin.category.delete', $item->id) }}" class="btn btn-sm btn-dark" onclick="return confirm('Are you sure ?')" data-bs-toggle="tooltip" title="Delete">
                                                        <i class="fa fa-trash"></i>
                                                    </a> --}}
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