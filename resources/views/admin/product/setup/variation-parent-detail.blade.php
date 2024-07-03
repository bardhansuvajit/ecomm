@extends('admin.layout.app-product-setup')
@section('page-title', 'Product - Variation detail')

@section('product-setup')
<div class="row mb-3">
    <div class="col-md-10">
        <h5 class="text-primary">Variations under <strong><i>{{ $parent_variation->title }}</i></strong></h5>
        <p class="small text-muted">Drag &amp; drop table content to re-order their position</p>
    </div>
    <div class="col-md-2 text-right">
        <a href="{{ route('admin.product.setup.variation', $data->id) }}" class="btn btn-primary btn-sm"> <i class="fa fa-chevron-left"></i> Back</a>
    </div>
</div>

<div class="d-flex sortable" data-position-update-route="{{ route('admin.product.setup.variation.child.position', [$request->id, $parent_variation->id]) }}" data-csrf-token="{{ csrf_token() }}">
    <div class="card mr-3 bg-primary">
        <a href="{{ route('admin.product.setup.variation.child.create', [$data->id, $parent_variation->id]) }}">
            <div class="card-body text-center">
                <h6 class="mb-4 font-weight-bold"><i class="fa fa-plus"></i></h6>
                <p class="small">Create new variation</p>
            </div>
        </a>
    </div>
    @foreach ($parent_variation->variationChildern as $index => $child_variation)
        <div class="card mr-3 single {{ ($child_variation->status == 0) ? 'bg-inactive' : '' }}" id="{{ $child_variation->id }}">
            <div class="card-body">
                @if ($child_variation->image_medium)
                    <img src="{{ asset($child_variation->image_medium) }}" alt="image" class="variation-image">
                    <br>
                @endif

                <h6 class="mb-0 font-weight-bold">{{ $child_variation->title }}</h6>

                @if (!empty($child_variation->pricingDetails) && count($child_variation->pricingDetails) > 0)
                    @foreach ($child_variation->pricingDetails as $childPrice)
                        <p class="text-muted mb-0">
                            <del>{!! $childPrice->currency->entity !!}{{ $childPrice->mrp }}</del>
                            <span>{!! $childPrice->currency->entity !!}{{ $childPrice->selling_price }}</span>
                        </p>
                    @endforeach
                @endif
                <p class="small"></p>

                <hr>

                <div class="buttons mt-3">
                    <div class="btn-group">
                        <div class="custom-control custom-switch mt-1" data-bs-toggle="tooltip" title="Toggle status">
                            <input type="checkbox" class="custom-control-input" id="customSwitch{{$child_variation->id}}" {{ ($child_variation->status == 1) ? 'checked' : '' }} onchange="statusToggle('{{ route('admin.product.setup.variation.child.status', $child_variation->id) }}')">
                            <label class="custom-control-label" for="customSwitch{{$child_variation->id}}"></label>
                        </div>

                        <a href="" class="btn btn-sm btn-dark" data-bs-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>

                        <a href="{{ route('admin.product.setup.variation.child.delete', $child_variation->id) }}" class="btn btn-sm btn-dark" data-bs-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure ?')"><i class="fa fa-trash"></i></a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection

@section('script')
    <script>
        
    </script>
@endsection
