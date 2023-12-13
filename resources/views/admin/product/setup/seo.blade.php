@extends('admin.layout.app-product-setup')
@section('page-title', 'Product - SEO')

@section('product-setup')
<form action="{{ route('admin.product.setup.store.seo') }}" method="post" enctype="multipart/form-data">@csrf

    <div class="form-group">
        <label for="page_title">Page title <span class="text-muted">(Optional)</span></label>
        <textarea name="page_title" id="page_title" class="form-control" placeholder="Enter Page title">{{ old('page_title') }}</textarea>
        @error('page_title') <p class="small text-danger">{{ $message }}</p> @enderror
    </div>

    <div class="form-group">
        <label for="meta_title">Meta title <span class="text-muted">(Optional)</span></label>
        <textarea name="meta_title" id="meta_title" class="form-control" placeholder="Enter Meta title">{{ old('meta_title') }}</textarea>
        @error('meta_title') <p class="small text-danger">{{ $message }}</p> @enderror
    </div>

    <div class="form-group">
        <label for="meta_desc">Meta Description <span class="text-muted">(Optional)</span></label>
        <textarea name="meta_desc" id="meta_desc" class="form-control" placeholder="Enter Meta Description">{{ old('meta_desc') }}</textarea>
        @error('meta_desc') <p class="small text-danger">{{ $message }}</p> @enderror
    </div>

    <div class="form-group">
        <label for="meta_keyword">Meta Keyword <span class="text-muted">(Optional)</span></label>
        <textarea name="meta_keyword" id="meta_keyword" class="form-control" placeholder="Enter Meta Keyword">{{ old('meta_keyword') }}</textarea>
        @error('meta_keyword') <p class="small text-danger">{{ $message }}</p> @enderror
    </div>

    <input type="hidden" name="product_id" value="{{ $request->id }}">
    <button type="submit" class="btn btn-primary">Save &amp; Next</button>
</form>
@endsection