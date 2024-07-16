@extends('admin.layout.app-product-setup')
@section('page-title', 'Product - Variation')

@section('product-setup')
<div class="row mb-3">
    <div class="col-md-6">
        <ul class="nav nav-underline">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="{{ url()->current() }}">Information</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.product.setup.variation.position', $request->id) }}">Thumb</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Pricing</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Images</a>
            </li>
        </ul>
    </div>
    <div class="col-md-6 text-right">
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
                            @if (!empty($item->thumb_path) && file_exists($item->thumb_path))
                                <div class="col-md-3">
                                    <img src="{{ asset($item->thumb_path) }}" alt="" width="img-thumbnail" style="height: 200px">

                                    <p class="text-muted">You can change thumb from here</p>
                                    <form action="{{ route('admin.product.setup.variation.update', $request->id) }}" method="post" enctype="multipart/form-data">@csrf
                                        <div class="form-group">
                                            <label for="thumb_path">Thumb image <span class="text-muted">*</span></label>
                                            <input type="file" class="form-control" name="thumb_path" id="thumb_path">
                                            {!! imageUploadNotice('variation')['html'] !!}
                                            @error('thumb_path') <p class="small text-danger">{{ $message }}</p> @enderror
                                        </div>

                                        <input type="hidden" name="id" value="{{ $item->id }}">
                                        <div class="btn-group">
                                            <button type="submit" class="btn btn-primary">Upload & Change</button>

                                            <a href="{{ route('admin.product.setup.variation.thumb.remove', [$request->id, $item->id]) }}" class="btn btn-danger" onclick="return confirm('Are you sure ?')">Remove Thumb</a>

                                            <div class="custom-control custom-switch ms-3 mt-1" data-bs-toggle="tooltip" title="Toggle Image status">
                                                <input type="checkbox" class="custom-control-input" id="customSwitchImage{{$item->id}}" {{ ($item->thumb_status == 1) ? 'checked' : '' }} onchange="statusToggle('{{ route('admin.product.setup.variation.image.status', $item->id) }}')">

                                                <label class="custom-control-label" for="customSwitchImage{{$item->id}}"></label>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @else
                                <div class="col-md-3">
                                    <h5 class="text-dark">No thumb found</h5>
                                    <p class="text-muted">No thumb found for this option. You can browse &amp; upload from here </p>
                                    <form action="{{ route('admin.product.setup.variation.update', $request->id) }}" method="post" enctype="multipart/form-data">@csrf
                                        <div class="form-group">
                                            <label for="thumb_path">Thumb <span class="text-muted">*</span></label>
                                            <input type="file" class="form-control" name="thumb_path" id="thumb_path">
                                            {!! imageUploadNotice('variation')['html'] !!}
                                            @error('thumb_path') <p class="small text-danger">{{ $message }}</p> @enderror
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

                <div class="card mb-5">
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

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Images</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.product.setup.variation.images', $request->id) }}" method="post" enctype="multipart/form-data">@csrf
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label for="images">Images *</label>
                                    <input type="file" class="form-control" name="images[]" id="images" accept=".jpg, .jpeg, .png" multiple>
                                    {!! imageUploadNotice('product')['html'] !!}
                                    @error('images') <p class="small text-danger">{{ $message }}</p> @enderror
                                    @error('images.*') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <input type="hidden" name="product_id" value="{{ $request->id }}">
                            <input type="hidden" name="product_variation_id" value="{{ $item->id }}">
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </form>

                        @if (!empty($item->images) && count($item->images) > 0)
                            <hr>

                            <div class="row">
                                <div class="col-md-6">
                                    <p class="text-muted">Uploaded images: {{ count($item->images) }} </p>
                                </div>
                                <div class="col-md-6 text-right">
                                    <p class="small text-muted text-right">Drag &amp; drop content to re-order their position</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 mb-3">
                                    <ul class="nav nav-pills" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a href="javascript: void(0)" class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all">All images</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="javascript: void(0)" class="nav-link"id="detailed-tab" data-bs-toggle="tab" data-bs-target="#detailed">Detailed</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="tab-content">
                                <div class="tab-pane active" id="all" role="tabpanel" aria-labelledby="all-tab">
                                    <div class="row mb-4 sortable" data-position-update-route="{{ route('admin.product.setup.images.position.update') }}" data-csrf-token="{{ csrf_token() }}">
                                        @foreach ($item->images as $index => $image)
                                            <div class="col-md-2 single" id="{{ $image->id }}">
                                                @if (!empty($image->img_medium) && file_exists(public_path($image->img_medium)))
                                                    <img src="{{ asset($image->img_medium) }}" alt="image" class="img-thumbnail w-100 position-relative" 
                                                    @if($image->status == 0)
                                                        style="filter: blur(4px)"
                                                    @endif
                                                    >
                                                @else
                                                    <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" alt="corrupt-image" class="mr-2 w-100"
                                                    @if($image->status == 0)
                                                        style="filter: blur(4px)"
                                                    @endif
                                                    >
                                                @endif

                                                <a href="{{ route('admin.product.setup.images.delete', $image->id) }}" class="btn btn-sm btn-danger" style="position:absolute; top:0; right:0" onclick="return confirm('Are you sure ?')">
                                                    <i class="fas fa-times"></i>
                                                </a>

                                                {{-- @if($index == 0) --}}
                                                {{-- @if($image->status == 1 )
                                                    <p class="small text-muted mt-2">
                                                        <i class="fas fa-info-circle"></i>
                                                        This will be the featured image
                                                    </p>
                                                @endif --}}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="tab-pane" id="detailed" role="tabpanel" aria-labelledby="detailed-tab">
                                    <table class="table table-sm table-hover mb-3">
                                        <thead>
                                            <tr>
                                                <th style="width: 10px">#</th>
                                                <th>Small</th>
                                                <th>Medium</th>
                                                <th>Large</th>
                                                <th style="width: 100px">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($item->images as $index => $image)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>
                                                        @if (!empty($image->img_small) && file_exists(public_path($image->img_small)))
                                                            <img src="{{ asset($image->img_small) }}" alt="image" class="" style="height: 50px">
                                                        @else
                                                            <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" alt="corrupt-image" style="height: 50px" class="mr-2">
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (!empty($image->img_medium) && file_exists(public_path($image->img_medium)))
                                                            <img src="{{ asset($image->img_medium) }}" alt="image" class="" style="height: 50px">
                                                        @else
                                                            <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" alt="corrupt-image" style="height: 50px" class="mr-2">
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (!empty($image->img_large) && file_exists(public_path($image->img_large)))
                                                            <img src="{{ asset($image->img_large) }}" alt="image" class="" style="height: 50px">
                                                        @else
                                                            <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" alt="corrupt-image" style="height: 50px" class="mr-2">
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="d-flex">
                                                            <div class="custom-control custom-switch mt-1" data-bs-toggle="tooltip" title="Toggle status">
                                                                <input type="checkbox" class="custom-control-input" id="customSwitch{{$image->id}}" {{ ($image->status == 1) ? 'checked' : '' }} onchange="statusToggle('{{ route('admin.product.setup.images.status', $image->id) }}')">
                                                                <label class="custom-control-label" for="customSwitch{{$image->id}}"></label>
                                                            </div>
                            
                                                            <div class="btn-group">
                                                                <a href="{{ route('admin.product.setup.images.delete', $image->id) }}" class="btn btn-sm btn-dark" onclick="return confirm('Are you sure ?')" data-bs-toggle="tooltip" title="Delete">
                                                                    <i class="fa fa-trash"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
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