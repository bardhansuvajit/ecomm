@extends('admin.layout.app-product-setup')
@section('page-title', 'Product - Variation edit')

@section('product-setup')
<div class="row">
    <div class="col-md-12">
        <form action="{{ route('admin.product.setup.variation.parent.update') }}" method="post" enctype="multipart/form-data">@csrf
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="title">Title <span class="text-muted">*</span></label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="Variation title" value="{{ old('title') ? old('title') : $parent_variation->title }}" autofocus>
                    @error('title') <p class="small text-danger">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-12">
                    <label for="short_desc">Short description <span class="text-muted">(Optional - within 1000 words)</span></label>
                    <textarea name="short_desc" id="short_desc" class="form-control" placeholder="Enter Short description">{{ old('title') ? old('title') : $parent_variation->short_desc }}</textarea>
                    @error('short_desc') <p class="small text-danger">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-12">
                    <label for="detailed_desc">Detailed description <span class="text-muted">(Optional)</span></label>
                    <textarea name="detailed_desc" id="detailed_desc" class="form-control" placeholder="Enter Detailed description">{{ old('title') ? old('title') : $parent_variation->detailed_desc }}</textarea>
                    @error('detailed_desc') <p class="small text-danger">{{ $message }}</p> @enderror
                </div>
            </div>

            <input type="hidden" name="id" value="{{ $parent_variation->id }}">
            <input type="hidden" name="product_id" value="{{ $data->id }}">
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
@endsection

@section('script')
    <script>
        
    </script>
@endsection
