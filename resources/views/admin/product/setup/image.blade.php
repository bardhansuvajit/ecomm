@extends('admin.layout.app-product-setup')
@section('page-title', 'Product - Image')

@section('product-setup')
<form action="{{ route('admin.product.setup.store.images') }}" method="post" enctype="multipart/form-data">@csrf

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
    <button type="submit" class="btn btn-primary">Save &amp; Next</button>

</form>

@if (!empty($data->imageDetails) && count($data->imageDetails) > 0)
    <hr>

    <div class="row">
        <div class="col-md-6">
            <p class="text-muted">Uploaded images: {{ count($data->imageDetails) }} </p>
        </div>
        <div class="col-md-6 text-right">
            <p class="small text-muted text-right">Drag &amp; drop content to re-order their position</p>
        </div>
    </div>

    <div class="row">
        <div class="col-12 mb-3">
            <ul class="nav nav-pills" id="myTab" role="tablist">
                <li class="nav-item">
                    <a href="javascript: void(0)" class="nav-link active" id="all-tab" data-toggle="tab" data-target="#all">All images</a>
                </li>
                <li class="nav-item">
                    <a href="javascript: void(0)" class="nav-link"id="detailed-tab" data-toggle="tab" data-target="#detailed">Detailed</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="tab-content">
        <div class="tab-pane active" id="all" role="tabpanel" aria-labelledby="all-tab">
            <div class="row mb-4 sortable" data-position-update-route="{{ route('admin.product.setup.images.position.update') }}" data-csrf-token="{{ csrf_token() }}">
                @foreach ($data->imageDetails as $index => $image)
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
            <table class="table table-sm table-hover">
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
                    @foreach ($data->imageDetails as $index => $image)
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
                            <td class="d-flex">
                                <div class="custom-control custom-switch mt-1" data-toggle="tooltip" title="Toggle status">
                                    <input type="checkbox" class="custom-control-input" id="customSwitch{{$image->id}}" {{ ($image->status == 1) ? 'checked' : '' }} onchange="statusToggle('{{ route('admin.product.setup.images.status', $image->id) }}')">
                                    <label class="custom-control-label" for="customSwitch{{$image->id}}"></label>
                                </div>

                                <div class="btn-group">
                                    <a href="{{ route('admin.product.setup.images.delete', $image->id) }}" class="btn btn-sm btn-dark" onclick="return confirm('Are you sure ?')" data-toggle="tooltip" title="Delete">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
@endsection
