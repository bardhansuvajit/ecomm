@extends('admin.layout.app-product-setup')
@section('page-title', 'Product - Variation create')

@section('product-setup')
<div class="row mb-3">
    <div class="col-md-10">
        <h5 class="text-primary">Create new Variation under <strong><i>{{ $parent_variation->title }}</i></strong></h5>
    </div>
    <div class="col-md-2 text-right">
        <a href="{{ route('admin.product.setup.variation', $data->id) }}" class="btn btn-primary btn-sm"> <i class="fa fa-chevron-left"></i> Back</a>
    </div>
</div>

<hr>

<div class="row">
    <div class="col-md-12">
        <form action="{{ route('admin.product.setup.store.variation.child') }}" method="post" enctype="multipart/form-data">@csrf
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="image">Image <span class="text-muted">(Optional)</span></label>
                    <input type="file" name="image" id="image" class="form-control">
                    {!! imageUploadNotice('variation')['html'] !!}
                    @error('image') <p class="small text-danger">{{ $message }}</p> @enderror
                </div>
                <div class="col-md-6">
                    <label for="title">Title <span class="text-muted">*</span></label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="Variation title" value="{{ old('title') }}" autofocus>
                    @error('title') <p class="small text-danger">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-12">
                    <label for="short_description">Short description <span class="text-muted">(Optional - within 1000 words)</span></label>
                    <textarea name="short_description" id="short_description" class="form-control" placeholder="Enter Short description">{{ old('short_description') }}</textarea>
                    @error('short_description') <p class="small text-danger">{{ $message }}</p> @enderror
                </div>
            </div>

            <hr>

            <h5 class="text-primary">Product related information (Optional)</h5>

            <div class="form-group row">
                <div class="col-md-12">
                    <label for="product_title">Title <span class="text-muted">(Optional - within 1000 words)</span></label>
                    <textarea name="product_title" id="product_title" class="form-control" placeholder="Enter Title">{{ old('product_title') }}</textarea>
                    @error('product_title') <p class="small text-danger">{{ $message }}</p> @enderror
                </div>
            </div>

            <input type="hidden" name="parent_id" value="{{ $variationParentId }}">
            <input type="hidden" name="product_id" value="{{ $data->id }}">
            <button type="submit" class="btn btn-primary">Save &amp; Next</button>
        </form>
    </div>
</div>
@endsection

@section('script')
    <script>
        
    </script>
@endsection