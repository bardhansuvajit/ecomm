@extends('admin.layout.app')
@section('page-title', 'Edit variation option')

@section('section')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row mb-3">
                            <div class="col-md-12 text-right">
                                <a href="{{ route('admin.product.variation.option.list') }}" class="btn btn-sm btn-primary"> <i class="fa fa-chevron-left"></i> Back</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.product.variation.option.update') }}" method="post" enctype="multipart/form-data">@csrf
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label for="variation_id">Variation <span class="text-muted">*</span></label>
                                    <select class="form-select" name="variation_id" id="variation_id">
                                        <option value="" selected disabled>Select</option>
                                        @forelse ($variations['data'] as $variation)
                                            <option value="{{$variation->id}}" {{ ($data->variation_id == $variation->id) ? 'selected' : '' }}>{{$variation->title}}</option>
                                        @empty
                                            <option value="">No data found</option>
                                        @endforelse
                                    </select>
                                    @error('variation_id') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="value">Value <span class="text-muted">*</span></label>
                                    <input type="text" class="form-control" name="value" id="value" placeholder="" value="{{ old('value') ? old('value') : $data->value }}" autofocus>
                                    @error('value') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="category">Category <span class="text-muted">(optional in comma separated)</span></label>
                                <textarea name="category" id="category" class="form-control" placeholder="shoes,men,women" rows="2">{{ old('category') ? old('category') : $data->category }}</textarea>
                                @error('category') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                            <div class="form-group">
                                <label for="equivalent">Equivalent <span class="text-muted">(optional in JSON format)</span></label>
                                <textarea name="equivalent" id="equivalent" class="form-control" placeholder='{"name":"EURO 40"}' rows="2">{{ old('equivalent') ? old('equivalent') : $data->equivalent }}</textarea>
                                @error('equivalent') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                            <div class="form-group">
                                <label for="information">Information <span class="text-muted">(optional in JSON format)</span></label>
                                <textarea name="information" id="information" class="form-control" placeholder='{"lenth":"25cm"}' rows="2">{{ old('information') ? old('information') : $data->information }}</textarea>
                                @error('information') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                            <div class="form-group">
                                <label for="short_description">Short Description <span class="text-muted">(optional)</span></label>
                                <textarea name="short_description" id="short_description" class="form-control" placeholder="" rows="2">{{ old('short_description') ? old('short_description') : $data->short_description }}</textarea>
                                @error('short_description') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                            <div class="form-group">
                                <label for="long_description">Long Description <span class="text-muted">(optional)</span></label>
                                <textarea name="long_description" id="long_description" class="form-control" placeholder="" rows="4">{{ old('long_description')  ? old('long_description') : $data->long_description}}</textarea>
                                @error('long_description') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                            <input type="hidden" name="id" value="{{ $data->id }}">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
    <script>
        
    </script>
@endsection