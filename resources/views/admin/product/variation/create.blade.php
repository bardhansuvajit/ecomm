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
                        <select name="parent" id="parent" class="form-select form-select-sm" style="width: 150px;">
                            <option value="">Select variation...</option>
                            @forelse ($all_variations['data'] as $parent)
                                <option value="{{ $parent->id }}" {{ (request()->input('parent') == $parent->id) ? 'selected' : '' }}>{{ $parent->title }}</option>
                            @empty
                                <option value="">No data found</option>
                            @endforelse
                        </select>
                    </div>

                    {{-- <div class="form-group ml-2">
                        <select name="category" id="category" class="form-select form-select-sm" style="width: 150px;">
                            <option value="">Select category...</option>
                            @forelse ($categories['data'] as $category)
                                <option value="{{ $category }}" {{ (request()->input('category') == $category) ? 'selected' : '' }}>{{ ucwords($category) }}</option>
                            @empty
                                <option value="">No data found</option>
                            @endforelse
                        </select>
                    </div> --}}

                    <div class="form-group ml-2">
                        <input type="search" class="form-control form-control-sm" name="keyword" id="keyword" value="{{ request()->input('keyword') }}" placeholder="Search variation...">
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

    @if (!empty($variations['data']) && count($variations['data']) > 0)
        @foreach ($variations['data'] as $parent)
            <div class="col-md-12">
                <div class="row">
                    <div class="col-12">
                        <h5 class="fw-bold text-primary mb-3">{{ $parent->title }}</h5>
                    </div>

                    {{-- {{ dd($data->variationOptions->pluck('')) }} --}}

                    <div class="col-12">
                        @foreach ($parent->groupedOptions as $category => $options)
                            <h6 class="text-secondary mt-4">{{ strtoupper($category) }}</h6>
                            <div class="btn-group btn-group-wrap">
                                @foreach ($options as $option)
                                    <input type="checkbox" class="btn-check" name="btnradio" id="btnradio{{ $option->id }}" autocomplete="off" {{ collect($data->variationOptions->pluck('variation_option_id'))->contains($option->id) ? 'checked' : '' }}>

                                    <label class="btn btn-outline-dark" for="btnradio{{ $option->id }}" onclick="productVariationToggle({{ $request->id }}, {{ $option->id }}, '{{ route('admin.product.setup.variation.toggle') }}', '{{ csrf_token() }}')">
                                        <p class="mb-0">{{ $option->value }}</p>
                                    </label>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>

                @if(!$loop->last) <hr class="my-5"> @endif
            </div>
        @endforeach
    @else
        <div class="col-12 text-center my-5">
            <p class="text-muted my-5">No data found</p>
        </div>
    @endif

</div>
@endsection

@section('script')
    <script>

    </script>
@endsection