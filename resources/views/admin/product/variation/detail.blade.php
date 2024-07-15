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
        <div class="card bg-light border-0 shadow-none">
            <div class="card-body">
                <h5 class="display-6 fw-bold mb-4">{{ $item->variationOption->value }}</h5>

                <div class="card mb-5">
                    <div class="card-header">
                        <h5 class="mb-0">Thumb</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            @if (!empty($item->image_path) && file_exists($item->image_path))
                                <div class="col-md-3">
                                    <img src="{{ asset($item->image_path) }}" alt="" width="img-thumbnail" style="height: 200px">

                                    <p class="text-muted">You can change thumb from here</p>
                                    <form action="{{ route('admin.product.setup.variation.update', $request->id) }}" method="post" enctype="multipart/form-data">@csrf
                                        <div class="form-group">
                                            <label for="image_path">Thumb image <span class="text-muted">*</span></label>
                                            <input type="file" class="form-control" name="image_path" id="image_path">
                                            {!! imageUploadNotice('variation')['html'] !!}
                                            @error('image_path') <p class="small text-danger">{{ $message }}</p> @enderror
                                        </div>

                                        <input type="hidden" name="id" value="{{ $item->id }}">
                                        <div class="btn-group">
                                            <button type="submit" class="btn btn-primary">Upload & Change</button>

                                            <a href="{{ route('admin.product.setup.variation.image.remove', [$request->id, $item->id]) }}" class="btn btn-danger" onclick="return confirm('Are you sure ?')">Remove Thumb</a>

                                            <div class="custom-control custom-switch ms-3 mt-1" data-bs-toggle="tooltip" title="Toggle Image status">
                                                <input type="checkbox" class="custom-control-input" id="customSwitchImage{{$item->id}}" {{ ($item->image_status == 1) ? 'checked' : '' }} onchange="statusToggle('{{ route('admin.product.setup.variation.image.status', $item->id) }}')">

                                                <label class="custom-control-label" for="customSwitchImage{{$item->id}}"></label>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @else
                                <div class="col-md-3">
                                    <h5 class="text-dark">No image found</h5>
                                    <p class="text-muted">No image found for this option. You can browse &amp; upload from here </p>
                                    <form action="{{ route('admin.product.setup.variation.update', $request->id) }}" method="post" enctype="multipart/form-data">@csrf
                                        <div class="form-group">
                                            <label for="image_path">Image <span class="text-muted">*</span></label>
                                            <input type="file" class="form-control" name="image_path" id="image_path">
                                            {!! imageUploadNotice('variation')['html'] !!}
                                            @error('image_path') <p class="small text-danger">{{ $message }}</p> @enderror
                                        </div>

                                        <input type="hidden" name="id" value="{{ $item->id }}">
                                        <button type="submit" class="btn btn-primary">Upload</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card mb-5">
                    <div class="card-header">
                        <h5 class="mb-0">Pricing</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <form action="{{ route('admin.product.setup.variation.update.pricing', $request->id) }}" method="post" enctype="multipart/form-data">@csrf

                                @foreach ($currencies as $cIndex => $currency)
                                <input type="hidden" name="currency_id[]" value="{{ $currency->id }}">

                                @if ($errors->has('currency_id.'.$cIndex))
                                    <p class="small text-danger">{{ $errors->get('currency_id.'.$cIndex)[0] }}</p>
                                @endif

                                <div class="form-group row">
                                    <div class="col-12">
                                        <h5 class="text-primary font-weight-bold">
                                            {!! $currency->entity !!} - 
                                            <span class="text-primary">{{ strtoupper($currency->name) }}</span>    
                                            <small class="text-muted">({{ $currency->full_name }})</small>    
                                        </h5>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="cost">Cost <span class="text-muted">(Optional)</span></label>

                                        {{-- {{ $item->pricing }} --}}

                                        <input type="number" step=".01" class="form-control" name="cost[]" id="cost" placeholder="Enter cost" value="{{ old('cost.'.$cIndex) ? old('cost.'.$cIndex) : (count($item->pricing) > 0 ? $item->pricing[$cIndex]->cost : '') }}">

                                        <p class="text-muted">Helps to calculate profit</p>

                                        @if ($errors->has('cost.'.$cIndex))
                                            <p class="small text-danger">{{ $errors->get('cost.'.$cIndex)[0] }}</p>
                                        @endif
                                    </div>

                                    <div class="col-md-4">
                                        <label for="mrp">MRP <span class="text-muted">(Optional)</span></label>

                                        <input type="number" step=".01" class="form-control" name="mrp[]" id="mrp" placeholder="Enter MRP" value="{{ old('mrp.'.$cIndex) ? old('mrp.'.$cIndex) : (count($item->pricing) > 0 ? $item->pricing[$cIndex]->mrp : '') }}">

                                        <p class="text-muted">When you want to add discount</p>

                                        @if ($errors->has('mrp.'.$cIndex))
                                            <p class="small text-danger">{{ $errors->get('mrp.'.$cIndex)[0] }}</p>
                                        @endif
                                    </div>

                                    <div class="col-md-4">
                                        <label for="selling_price">Selling price *</label>

                                        <input type="number" step=".01" class="form-control" name="selling_price[]" id="selling_price" placeholder="Enter selling price" value="{{ old('selling_price.'.$cIndex) ? old('selling_price.'.$cIndex) : (count($item->pricing) > 0 ? $item->pricing[$cIndex]->selling_price : '') }}">

                                        @if ($errors->has('selling_price.'.$cIndex))
                                            <p class="small text-danger">{{ $errors->get('selling_price.'.$cIndex)[0] }}</p>
                                        @endif
                                    </div>
                                </div>

                                @if (!$loop->last) <hr> @endif

                                @endforeach

                                <input type="hidden" name="product_id" value="{{ $request->id }}">
                                <input type="hidden" name="product_variation_id" value="{{ $item->id }}">
                                <button type="submit" class="btn btn-primary">Save </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Other informations</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-0">Parent: {{ $item->variationOption->parent->title }}</p>
                        <p class="text-muted mb-0">Category: {{ $item->variationOption->category }}</p>
                        <p class="text-muted mb-0">Equivalent: {{ $item->variationOption->equivalent }}</p>
                        <p class="text-muted">Information: {{ $item->variationOption->information }}</p>
                        {{-- <a href="#" class="btn btn-primary">Go somewhere</a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>

    </script>
@endsection