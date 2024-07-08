@extends('admin.layout.app-product-setup')
@section('page-title', 'Product - Variation')

@section('product-setup')
<div class="row mb-3">
    <div class="col-md-12 text-right">
        <a href="{{ route('admin.product.setup.variation.index', $request->id) }}" class="btn btn-primary btn-sm">
            <i class="fa fa-chevron-left"></i> Back
        </a>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="filter">
            <form action="" method="get">
                <div class="d-flex justify-content-end">
                    <div class="form-group ml-2">
                        <select name="id" id="id" class="form-select form-select-sm" style="width: 150px;">
                            <option value="">Select variation...</option>
                            <option value="" {{ (request()->input('id') === null || request()->input('id') === '') ? 'selected' : '' }}>All</option>
                            @foreach ($variations['data'] as $parent)
                                <option value="{{ $parent->id }}" {{ (request()->input('id') == $parent->id) ? 'selected' : '' }}>{{ $parent->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group ml-2">
                        <select name="category" id="category" class="form-select form-select-sm" style="width: 150px;">
                            <option value="">Select category...</option>
                            @foreach ($categories['data'] as $category)
                                <option value="{{ $category }}" {{ (request()->input('category') == $category) ? 'selected' : '' }}>{{ ucwords($category) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group ml-2">
                        <select name="status" id="status" class="form-select form-select-sm" style="width: 150px;">
                            <option value="">Select status...</option>
                            <option value="" {{ (request()->input('status') === null || request()->input('status') === '') ? 'selected' : '' }}>All</option>
                            <option value="1" {{ (request()->input('status') == '1') ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ (request()->input('status') == '0') ? 'selected' : '' }}>Inactive</option>
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

    @foreach ($variations['data'] as $parent)
        <div class="col-md-12">
            <div class="row">
                <div class="col-12">
                    <h5 class="fw-bold text-primary mb-3">{{ $parent->title }}</h5>
                </div>

                <div class="col-12">
                    <div class="btn-group btn-group-wrap">
                        @foreach ($parent->activeOptions as $option)
                            <input type="checkbox" class="btn-check" name="btnradio" id="btnradio{{ $option->id }}" autocomplete="off">
                            <label class="btn btn-outline-dark" for="btnradio{{ $option->id }}">
                                <p class="mb-1">{{ $option->value }}</p>

                                <p class="small mb-0">{{ $option->category }}</p>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            @if(!$loop->last) <hr class="my-5"> @endif
        </div>
    @endforeach
</div>
@endsection

@section('script')
    <script>

    </script>
@endsection