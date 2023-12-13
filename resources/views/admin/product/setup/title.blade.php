@extends('admin.layout.app-product-setup')
@section('page-title', 'Product - Title')

@section('product-setup')
<form action="{{ route('admin.product.setup.store.title') }}" method="post" enctype="multipart/form-data">@csrf
    <div class="form-group">
        <label for="title">Title *</label>
        <input type="text" class="form-control" name="title" id="title" placeholder="Enter title" value="{{ old('title') ? old('title') : $data->title }}">
        @error('title') <p class="small text-danger">{{ $message }}</p> @enderror
    </div>

    <div class="form-group">
        <label for="short_description">Short description <span class="text-muted">(Optional - within 1000 characters)</span></label>

        <textarea name="short_description" id="short_description" class="form-control" placeholder="Enter short description" rows="7">{{ old('short_description') ? old('short_description') : $data->short_description }}</textarea>
        @error('short_description') <p class="small text-danger">{{ $message }}</p> @enderror
    </div>

    <input type="hidden" name="product_id" value="{{ $request->id }}">
    <button type="submit" class="btn btn-primary">Save &amp; Next <i class="fas fa-chevron-right"></i> </button>
</form>
@endsection