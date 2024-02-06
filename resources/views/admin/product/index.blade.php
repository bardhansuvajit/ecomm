@extends('admin.layout.app')
@section('page-title', 'Product list')

@section('section')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row mb-3">
                            <div class="col-md-12 text-right">
                                <a href="{{ route('admin.product.setup.category') }}" class="btn btn-sm btn-primary"> <i class="fa fa-plus"></i> Create</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6">
                                <form action="" method="get">
                                    <div class="d-flex justify-content-end">
                                        {{-- <div class="form-group">
                                            <select name="status" id="status" class="form-control form-control-sm">
                                                <option value="" selected disabled>Status...</option>
                                                <option value="0" {{ (request()->input('status') == 0) ? 'selected' : '' }}>Draft</option>
                                                <option value="1" {{ (request()->input('status') == 1) ? 'selected' : '' }}>Show</option>
                                                <option value="2" {{ (request()->input('status') == 2) ? 'selected' : '' }}>Hide</option>
                                                <option value="3" {{ (request()->input('status') == 3) ? 'selected' : '' }}>Out of Stock</option>
                                                <option value="4" {{ (request()->input('status') == 4) ? 'selected' : '' }}>Coming Soon</option>
                                            </select>
                                        </div>
                                        <div class="form-group ml-2">
                                            <select name="category" id="category" class="form-control form-control-sm">
                                                <option value="" selected disabled>Category...</option>
                                                @foreach ($activeCategories as $cat)
                                                    <option value="{{$cat->id}}" {{ (request()->input('category') == $cat->id) ? 'selected' : '' }}>{{$cat->title}}</option>
                                                @endforeach
                                            </select>
                                        </div> --}}
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
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Basic detail</th>
                                    <th>Quick edit</th>
                                    <th>Review</th>
                                    <th style="width: 120px">Status</th>
                                    <th style="width: 100px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $index => $item)
                                    <tr>
                                        <td>{{ $index + $data->firstItem() }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <div class="image-holder mr-3">
                                                    <a href="{{ route('admin.product.detail', $item->id) }}">
                                                    @if (count($item->frontImageDetails) > 0)
                                                        <img src="{{ asset($item->frontImageDetails[0]->img_large) }}" style="height:50px">
                                                    @else
                                                        {{-- <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" style="height:50px"> --}}
                                                    @endif
                                                    </a>
                                                </div>
                                                <div class="other-details">
                                                    @if ($item->title)
                                                        <p class="text-muted mb-1"><a href="{{ route('admin.product.detail', $item->id) }}">{{ $item->title }}</a></p>
                                                    @endif
                                                    {{-- {!! productCategoriesAdmin($item, 1) !!} --}}
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.product.setup.price', $item->id) }}" class="btn btn-sm btn-primary">Pricing</a>
                                            <a href="{{ route('admin.product.setup.images', $item->id) }}" class="btn btn-sm btn-primary">Images</a>
                                            <a href="{{ route('admin.product.setup.seo', $item->id) }}" class="btn btn-sm btn-primary">SEO</a>
                                            <a href="{{ route('admin.product.setup.usage', $item->id) }}" class="btn btn-sm btn-primary">Usage</a>
                                        </td>
                                        <td>
                                            @php
                                                $rating = ratingCalculation(json_decode($item->activeReviewDetails, true));
                                            @endphp
                                            <a href="{{ route('admin.product.review.index', $item->id) }}" class="btn btn-sm btn-{{ bootstrapRatingTypeColor($rating) }}">{{ $rating }} <i class="fas fa-star"></i> </a>
                                        </td>
                                        <td>
                                            <select name="status" id="status" class="form-control form-control-sm" data-route="{{ route('admin.product.status', $item->id) }}">
                                                @foreach ($statuses as $status)
                                                    <option value="{{ $status->id }}" {{ ($item->status == $status->id) ? 'selected' : '' }}>{{ $status->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="d-flex">
                                            <div class="btn-group">
                                                <a href="{{ route('admin.product.detail', $item->id) }}" class="btn btn-sm btn-dark" data-bs-toggle="tooltip" title="View">
                                                    <i class="fa fa-eye"></i>
                                                </a>

                                                <a href="{{ route('admin.product.setup.category.edit', $item->id) }}" class="btn btn-sm btn-dark" data-bs-toggle="tooltip" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>

                                                <a href="{{ route('admin.product.delete', $item->id) }}" class="btn btn-sm btn-dark" onclick="return confirm('Are you sure ?')" data-bs-toggle="tooltip" title="Delete">
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

<div class="modal fade" tabindex="-1" id="replacementProductModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select Replacement product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group ml-2">
                    <select name="rpclProId" id="rpclProId" class="form-control form-control-sm">
                        <option value="" selected disabled>Select...</option>
                        @foreach ($activeProducts as $prod)
                            <option value="{{$prod->id}}">{{$prod->title}}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="stateRoute">
                </div>
            </div>
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div> --}}
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        $('table select[name="status"]').on('change', function() {
            var val = $(this).find(':selected').val();
            var route = $(this).data('route');
            statusUpdate(route, val);
        });
    </script>
@endsection