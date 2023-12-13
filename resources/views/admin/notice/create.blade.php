@extends('admin.layout.app')
@section('page-title', 'Create notice')

@section('section')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row mb-3">
                            <div class="col-md-12 text-right">
                                <a href="{{ route('admin.management.notice.list.all') }}" class="btn btn-sm btn-primary"> <i class="fa fa-chevron-left"></i> Back</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.management.notice.store') }}" method="post" enctype="multipart/form-data">@csrf
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="image">Image <span class="text-muted">*</span></label>
                                    <input type="file" class="form-control" name="image" id="image">
                                    {!! imageUploadNotice('notice')['html'] !!}
                                    @error('image') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="text">Text</label>
                                    <textarea name="text" id="text" class="form-control" placeholder="Write notice here" rows="4" autofocus>{{ old('text') }}</textarea>
                                    @error('text') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="link">Link <span class="text-muted">(Optional)</span></label>
                                    <input type="text" class="form-control" name="link" id="link" placeholder="Enter redirect URL" value="{{ old('link') }}" maxlength="25">
                                    @error('link') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
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
