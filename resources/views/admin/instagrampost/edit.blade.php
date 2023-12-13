@extends('admin.layout.app')
@section('page-title', 'Edit instagrampost')

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
                        <form action="{{ route('admin.management.instagrampost.update') }}" method="post" enctype="multipart/form-data">@csrf
                            <div class="form-group">
                                @if (!empty($data->img_large))
                                    @if (!empty($data->img_large) && file_exists(public_path($data->img_large)))
                                        <img src="{{ asset($data->img_large) }}" alt="instagrampost-img" class="img-thumbnail mr-3" style="height: 50px">
                                    @else
                                        <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" alt="instagrampost-image" style="height: 50px" class="mr-2">
                                    @endif
                                    <br>
                                @endif

                                <label for="img_large">Image</label>
                                <input type="file" class="form-control" name="img_large" id="img_large">
                                @error('img_large') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                            <div class="form-group">
                                <label for="link">Link <span class="text-muted">(Optional)</span></label>
                                <input type="text" class="form-control" name="link" id="link" placeholder="Enter post link" value="{{ old('link') ? old('link') : $data->link }}" maxlength="25">
                                @error('link') <p class="small text-danger">{{ $message }}</p> @enderror
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
