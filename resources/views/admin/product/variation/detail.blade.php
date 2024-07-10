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
        <div class="card border-0 shadow-none">
            {{-- <img src="..." class="card-img-top" alt="..." style="width: 18rem"> --}}
            <div class="card-body">
                <div class="row mb-4">
                    @if (!empty($item->image_path) && file_exists($item->image_path))
                        <div class="col-md-3">
                            <img src="{{ asset($item->image_path) }}" alt="" width="img-thumbnail" style="height: 200px">

                            <p class="text-muted">You can change image from here</p>
                            <form action="{{ route('admin.product.setup.variation.update', $request->id) }}" method="post" enctype="multipart/form-data">@csrf
                                <div class="form-group">
                                    <label for="image_path">Image <span class="text-muted">*</span></label>
                                    <input type="file" class="form-control" name="image_path" id="image_path">
                                    {!! imageUploadNotice('variation')['html'] !!}
                                    @error('image_path') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>

                                <input type="hidden" name="id" value="{{ $item->id }}">
                                <button type="submit" class="btn btn-primary">Change</button>

                                <a href="{{ route('admin.product.setup.variation.remove.image', [$request->id, $item->id]) }}" class="btn btn-danger">Remove image</a>
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

                <h5 class="card-title fw-bold">{{ $item->variationOption->value }}</h5>
                <p class="text-muted mb-0">Parent: {{ $item->variationOption->parent->title }}</p>
                <p class="text-muted mb-0">Category: {{ $item->variationOption->category }}</p>
                <p class="text-muted mb-0">Equivalent: {{ $item->variationOption->equivalent }}</p>
                <p class="text-muted">Information: {{ $item->variationOption->information }}</p>
                {{-- <a href="#" class="btn btn-primary">Go somewhere</a> --}}
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>

    </script>
@endsection