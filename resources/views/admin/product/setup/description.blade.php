@extends('admin.layout.app-product-setup')
@section('page-title', 'Product - Description')

@section('style')
    <link rel="stylesheet" href="{{ asset('backend-assets/plugins/ckeditor5-36.0.1-sy1shf6t1itx/content-styles.css') }}">
@endsection

@section('product-setup')
<form action="{{ route('admin.product.setup.store.description') }}" method="post" enctype="multipart/form-data">@csrf

    <div class="form-group">
        <label for="description">Description</label>
        <textarea name="description" id="editor" class="form-control ckeditor" placeholder="Enter detailed description">{{ old('description') ? old('description') : $data->long_description }}</textarea>
        @error('description') <p class="small text-danger">{{ $message }}</p> @enderror
    </div>

    <input type="hidden" name="product_id" value="{{ $request->id }}">
    <button type="submit" class="btn btn-primary">Save &amp; Next</button>
</form>
@endsection

@section('script')
    <script src="{{ asset('backend-assets/plugins/ckeditor5-36.0.1-sy1shf6t1itx/build/ckeditor.js') }}"></script>
    <script src="{{ asset('backend-assets/js/ckeditor-custom.js') }}"></script>
@endsection