@extends('admin.layout.app')
@section('page-title', 'Create Instagram post')

@section('section')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row mb-3">
                            <div class="col-md-12 text-right">
                                <a href="{{ route('admin.management.instagrampost.list.all') }}" class="btn btn-sm btn-primary"> <i class="fa fa-chevron-left"></i> Back</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.management.instagrampost.store') }}" method="post" enctype="multipart/form-data">@csrf
                            <div class="form-group">
                                <label for="img_large">Image *</label>
                                <input type="file" class="form-control" name="img_large" id="img_large">
                                <p class="small text-muted">{{ $customGlobal->allImageUploadNotice }}</p>
                                @error('img_large') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                            <div class="form-group">
                                <label for="link">Link <span class="text-muted">(Optional)</span></label>
                                <input type="text" class="form-control" name="link" id="link" placeholder="Enter post link" value="{{ old('link') }}" maxlength="25">
                                @error('link') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Upload</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
