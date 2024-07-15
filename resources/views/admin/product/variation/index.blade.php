@extends('admin.layout.app-product-setup')
@section('page-title', 'Product - Variation')

@section('product-setup')
<div class="row mb-3">
    <div class="col-md-6">
        <ul class="nav nav-underline">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="{{ url()->current() }}">List</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.product.setup.variation.position', $request->id) }}">Position</a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" href="#">Trash</a>
            </li>
        </ul>
    </div>
    <div class="col-md-6 text-right">
        <a href="{{ route('admin.product.setup.variation.create', $request->id) }}" class="btn btn-primary btn-sm">
            <i class="fa fa-cog"></i> Set variation
        </a>
    </div>
</div>

<div class="row">
    @if (count($data->variationOptions) > 0)
        @php
            $groupedVariations = $data->variationOptions->groupBy(function ($option) {
                return $option->variationOption->variation_id;
            });
        @endphp

        @foreach ($groupedVariations as $options)
            <div class="card-group @if(!$loop->last) mb-5 @endif">
                <div class="card text-bg-light" style="width: 5rem; max-width: 5rem">
                    <div class="card-body d-flex align-items-center justify-content-center">
                        <h5 class="mb-0">{{ $options->first()->variationOption->parent->title }}</h4>
                    </div>
                </div>

                @foreach ($options as $option)
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex mb-3">
                                @if (!empty($option->image_path) && file_exists($option->image_path))
                                    <div class="flex-shrink-0 me-3">
                                        <div class="custom-control custom-switch" data-bs-toggle="tooltip" title="Toggle Image status">
                                            <input type="checkbox" class="custom-control-input" id="customSwitchImage{{$option->id}}" {{ ($option->image_status == 1) ? 'checked' : '' }} onchange="statusToggle('{{ route('admin.product.setup.variation.image.status', $option->id) }}')">

                                            <label class="custom-control-label" for="customSwitchImage{{$option->id}}">
                                                <img src="{{ asset($option->image_path) }}" style="height: 50px" class="">
                                            </label>
                                        </div>
                                    </div>
                                @endif
                                <div class="flex-grow-1">
                                    <h5 class="card-title fw-bold">{{ $option->variationOption->value }}</h5>

                                    @if (count($option->pricing) > 0)
                                        @foreach ($option->pricing as $price)
                                            <p class="text-muted mb-0">
                                                <del>{!! $price->currency->entity !!}{{ $price->mrp }}</del>
                                                {!! $price->currency->entity !!}{{ $price->selling_price }}
                                            </p>
                                        @endforeach
                                    @endif

                                    <p class="card-text text-muted">{{ $option->variationOption->category }}</p>
                                </div>
                            </div>

                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <a href="{{ route('admin.product.setup.variation.detail', [$request->id, $option->id]) }}" class="btn btn-sm btn-dark">Detail</a>
                                </div>
                                <div class="custom-control custom-switch" data-bs-toggle="tooltip" title="Toggle status">
                                    <input type="checkbox" class="custom-control-input" id="customSwitch{{$option->id}}" {{ ($option->status == 1) ? 'checked' : '' }} onchange="statusToggle('{{ route('admin.product.setup.variation.status', $option->id) }}')">
                                    <label class="custom-control-label" for="customSwitch{{$option->id}}"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    @else
        <div class="col-12 text-center my-5">
            <p class="text-muted my-5">No data added yet</p>
        </div>
    @endif
</div>
@endsection

@section('script')
    <script>

    </script>
@endsection