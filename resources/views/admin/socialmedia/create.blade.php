@extends('admin.layout.app')
@section('page-title', 'Create social media')

@section('section')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row mb-3">
                            <div class="col-md-12 text-right">
                                <a href="{{ route('admin.management.socialmedia.list.all') }}" class="btn btn-sm btn-primary"> <i class="fa fa-chevron-left"></i> Back</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.management.socialmedia.store') }}" method="post" enctype="multipart/form-data">@csrf

                            <div class="alert alert-danger"><i class="fas fa-info-circle"></i> Developer&apos;s section only. If you know what you are doing only then you can proceed. Social media icons set must match with <strong>Admin</strong> & <strong>Frontend</strong> both.</div>

                            <div class="form-group">
                                <label for="type">Social media type <span class="text-muted">*</span></label>
                                <input type="text" class="form-control" name="type" id="type" placeholder="eg: facebook" value="{{ old('type') }}" maxlength="25">
                                @error('type') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                            <div class="form-group">
                                <label for="icon_type">Icon type <span class="text-muted">*</span></label>
                                <input type="text" class="form-control" name="icon_type" id="icon_type" placeholder="eg: fontawesome" value="{{ old('icon_type') }}" maxlength="25">
                                @error('icon_type') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                            <div class="form-group">
                                <label for="icon_class">Icon class <span class="text-muted">*</span></label>
                                <input type="text" class="form-control" name="icon_class" id="icon_class" placeholder="eg: fa-brands fa-facebook-f" value="{{ old('icon_class') }}" maxlength="25">

                                <p class="text-muted my-2"><i class="fas fa-info-circle"> Fontawesome 6 - expects <strong>"fa-brands"</strong> class</i></p>
                                <p class="text-muted my-2"><i class="fas fa-info-circle"> Fontawesome 5 - expects <strong>"fa-fab"</strong> class</i></p>

                                @error('icon_class') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                            <div class="form-group">
                                <label for="link">Link <span class="text-muted">*</span></label>
                                <input type="text" class="form-control" name="link" id="link" placeholder="Enter media URL" value="{{ old('link') }}" maxlength="25">
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
