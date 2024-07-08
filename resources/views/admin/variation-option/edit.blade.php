@extends('admin.layout.app')
@section('page-title', 'Edit variation')

@section('section')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row mb-3">
                            <div class="col-md-12 text-right">
                                <a href="{{ route('admin.product.variation.list') }}" class="btn btn-sm btn-primary"> <i class="fa fa-chevron-left"></i> Back</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.product.variation.update') }}" method="post" enctype="multipart/form-data">@csrf
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label for="title">Name <span class="text-muted">*</span></label>
                                    <input type="text" class="form-control" name="title" id="title" placeholder="" value="{{ old('title') ?  old('title') : $data->title }}" autofocus>
                                    @error('title') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="short_description">Short Description <span class="text-muted">(optional)</span></label>
                                <textarea name="short_description" id="short_description" class="form-control" placeholder="Enter Short Description" rows="2">{{ old('short_description') ? old('short_description') : $data->short_description }}</textarea>
                                @error('short_description') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                            <div class="form-group">
                                <label for="long_description">Long Description <span class="text-muted">(optional)</span></label>
                                <textarea name="long_description" id="long_description" class="form-control" placeholder="Enter Long Description" rows="4">{{ old('long_description') ? old('long_description') : $data->long_description }}</textarea>
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