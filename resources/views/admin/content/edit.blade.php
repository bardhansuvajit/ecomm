@extends('admin.layout.app')
@section('page-title', $data->title)

@section('style')
    <link rel="stylesheet" href="{{ asset('backend-assets/plugins/ckeditor5-36.0.1-sy1shf6t1itx/content-styles.css') }}">
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
                                <a href="{{ route('front.content.contactus.index') }}" class="btn btn-sm btn-primary" target="_blank"> View public page <i class="fa fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.content.page.update') }}" method="post" enctype="multipart/form-data">@csrf
                            <div class="form-group">
                                <label for="content">Enter content</label>
                                <textarea name="content" id="editor" class="form-control ckeditor" placeholder="">{{ old('content') ? old('content') : $data->content }}</textarea>
                                @error('content') <p class="small text-danger">{{ $message }}</p> @enderror
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
    <script src="{{ asset('backend-assets/plugins/ckeditor5-36.0.1-sy1shf6t1itx/build/ckeditor.js') }}"></script>
    <script src="{{ asset('backend-assets/js/ckeditor-custom.js') }}"></script>
@endsection
