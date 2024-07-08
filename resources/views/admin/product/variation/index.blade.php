@extends('admin.layout.app-product-setup')
@section('page-title', 'Product - Variation')

@section('product-setup')
<div class="row mb-3">
    <div class="col-md-12 text-right">
        <a href="{{ route('admin.product.setup.variation.create', $request->id) }}" class="btn btn-primary btn-sm">
            <i class="fa fa-plus"></i> Add new variation
        </a>
    </div>
</div>

<div class="row">
    {{-- @foreach ($data->variationParents as $item)
    <div class="col-md-12">
        <div class="card shadow-none border">
            <div class="card-body">
                <div class="row">
                    <div class="col-10">
                        <h5 class="{{ (count($item->frontVariationChildern) == 0) ? 'text-danger font-weight-bold' : '' }} ">{{$item->title}}</h5>

                        @if ((count($item->frontVariationChildern) == 0))
                            <p class="small card-text">No variations found under <i>{{$item->title}}</i>. It will not be displayed in Frontend. <a href="{{ route('admin.product.setup.variation.child.create', [$data->id, $item->id]) }}">Add new</a></p>
                        @endif

                        <div class="btn-group">
                            @foreach ($item->frontVariationChildern as $index => $child_variation)
                                <input type="radio" class="btn-check" id="child-var-btn-{{$index}}" value="{{ $child_variation->id }}" name="child-var_id">
                                <label class="btn btn-light" for="child-var-btn-{{$index}}">
                                    @if ($child_variation->image_medium)
                                        <img src="{{ asset($child_variation->image_medium) }}" alt="image" class="variation-image">
                                        <br>
                                    @endif
                                    {{ $child_variation->title }}
                                </label>
                            @endforeach
                        </div>

                        @if ((count($item->frontVariationChildern) > 0))
                            <p class="small text-muted">Go to <a href="{{ route('admin.product.setup.variation.parent.detail', [$data->id, $item->id]) }}">details</a> to edit, delete & change position</p>
                        @endif
                    </div>
                    <div class="col-2 text-right">
                        <div class="btn-group">
                            <div class="custom-control custom-switch mt-1" data-bs-toggle="tooltip" title="Toggle status">
                                <input type="checkbox" class="custom-control-input" id="customSwitch{{$item->id}}" {{ ($item->status == 1) ? 'checked' : '' }} onchange="statusToggle('{{ route('admin.product.setup.variation.child.status', $item->id) }}')">
                                <label class="custom-control-label" for="customSwitch{{$item->id}}"></label>
                            </div>

                            <a href="{{ route('admin.product.setup.variation.child.create', [$data->id, $item->id]) }}" class="btn btn-sm btn-dark" data-bs-toggle="tooltip" title="Create">
                                <i class="fa fa-plus"></i>
                            </a>

                            <a href="{{ route('admin.product.setup.variation.parent.detail', [$data->id, $item->id]) }}" class="btn btn-sm btn-dark" data-bs-toggle="tooltip" title="Detail">
                                <i class="fa fa-eye"></i>
                            </a>

                            <a href="{{ route('admin.product.setup.variation.parent.edit', [$data->id, $item->id]) }}" class="btn btn-sm btn-dark" data-bs-toggle="tooltip" title="Edit">
                                <i class="fa fa-edit"></i>
                            </a>

                            <a href="{{ route('admin.product.setup.variation.parent.delete', $item->id) }}" class="btn btn-sm btn-dark" onclick="return confirm('Are you sure ?')" data-bs-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure ?')">
                                <i class="fa fa-trash"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach --}}
</div>
@endsection

@section('script')
    <script>

    </script>
@endsection