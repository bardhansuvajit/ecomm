@extends('admin.layout.app')
@section('page-title', 'Edit review')

@section('style')
    <link rel="stylesheet" href="{{ asset('backend-assets/plugins/select2/css/select2.min.css') }}">
@endsection

@section('section')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row mb-3">
                            <div class="col-md-12 text-right">
                                <a href="{{ route('admin.review.list.all') }}" class="btn btn-sm btn-primary"> <i class="fa fa-chevron-left"></i> Back</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.review.update') }}" method="post" enctype="multipart/form-data">@csrf
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="product_id">Product <span class="text-muted">*</span></label>
                                    <select class="select2 w-100" name="product_id" id="product_id" data-placeholder="Select product" data-dropdown-css-class="select2-purple">
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}" 
                                            {{ old('product_id') ? ( (old('product_id') == $product->id) ? 'selected' : '' ) : ( ($data->product_id == $product->id) ? 'selected' : '' ) }}
                                            {{-- {{ ($data->product_id == $product->id) ? 'selected' : '' }} --}}
                                            >{{ $product->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('product_id') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="rating">Rating <span class="text-muted">*</span></label>

                                    <div class="star-rating star-5">
                                        <input type="radio" name="rating" value="1" 
                                        {{ old('rating') ? ( (old('rating') == 1) ? 'checked' : '' ) : ( ($data->rating == 1) ? 'checked' : '' ) }}
                                        ><i></i>
                                        <input type="radio" name="rating" value="2" 
                                        {{ old('rating') ? ( (old('rating') == 2) ? 'checked' : '' ) : ( ($data->rating == 2) ? 'checked' : '' ) }}
                                        ><i></i>
                                        <input type="radio" name="rating" value="3" 
                                        {{ old('rating') ? ( (old('rating') == 3) ? 'checked' : '' ) : ( ($data->rating == 3) ? 'checked' : '' ) }}
                                        ><i></i>
                                        <input type="radio" name="rating" value="4" 
                                        {{ old('rating') ? ( (old('rating') == 4) ? 'checked' : '' ) : ( ($data->rating == 4) ? 'checked' : '' ) }}
                                        ><i></i>
                                        <input type="radio" name="rating" value="5" 
                                        {{ old('rating') ? ( (old('rating') == 5) ? 'checked' : '' ) : ( ($data->rating == 5) ? 'checked' : '' ) }}
                                        ><i></i>
                                    </div>
                                    @error('rating') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="heading">Heading <span class="text-muted">*</span></label>
                                <textarea name="heading" id="heading" class="form-control" placeholder="Enter heading" rows="2">{{ old('heading') ? old('heading') : $data->heading }}</textarea>
                                @error('heading') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                            <div class="form-group">
                                <label for="review">Review <span class="text-muted">*</span></label>
                                <textarea name="review" id="review" class="form-control" placeholder="Enter review" rows="4">{{ old('review') ? old('review') : $data->review }}</textarea>
                                @error('review') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                            <div class="form-group">
                                <label for="guest_review">User type *</label>
                                <div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="guest_review1" name="guest_review" value="1" class="custom-control-input" {{ (!old('guest_review') || old('guest_review') == 1) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="guest_review1">Guest user</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="guest_review2" name="guest_review" value="0" class="custom-control-input">
                                        <label class="custom-control-label" for="guest_review2">Existing user</label>
                                    </div>
                                </div>
                                @error('guest_review') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label for="name">Name <span class="text-muted">*</span></label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="" value="{{ old('name') ? old('name') : $data->name }}">
                                    @error('name') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="email">Email <span class="text-muted">(Optional)</span></label>
                                    <input type="email" class="form-control" name="email" id="email" placeholder="" value="{{ old('email') ? old('email') : $data->email }}">
                                    @error('email') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="phone_number">Phone number <span class="text-muted">(Optional)</span></label>
                                    <input type="text" class="form-control" name="phone_number" id="phone_number" placeholder="" value="{{ old('phone_number') ? old('phone_number') : $data->phone_number }}">
                                    @error('phone_number') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <input type="hidden" name="user_id" value="0">
                            <input type="hidden" name="review_id" value="{{ $data->id }}">
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
    <script src="{{ asset('backend-assets/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>
        $('.select2').select2();
    </script>
@endsection