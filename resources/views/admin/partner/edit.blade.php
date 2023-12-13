@extends('admin.layout.app')
@section('page-title', 'Edit partner')

@section('section')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row mb-3">
                            <div class="col-md-12 text-right">
                                <a href="{{ route('admin.management.partner.list.all') }}" class="btn btn-sm btn-primary"> <i class="fa fa-chevron-left"></i> Back</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.management.partner.update') }}" method="post" enctype="multipart/form-data">@csrf
                            <div class="form-group">
                                @if (!empty($data->img_large))
                                    @if (!empty($data->img_large) && file_exists(public_path($data->img_large)))
                                        <img src="{{ asset($data->img_large) }}" alt="partner-img" class="img-thumbnail mr-3" style="height: 50px">
                                    @else
                                        <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" alt="partner-image" style="height: 50px" class="mr-2">
                                    @endif
                                    <br>
                                @endif

                                <label for="img_large">Image</label>
                                <input type="file" class="form-control" name="img_large" id="img_large">
                                {!! imageUploadNotice('partner')['html'] !!}
                                @error('img_large') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                            <div class="form-group">
                                <label for="name">Name <span class="text-muted">(Optional - within 25 characters)</span></label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Enter name" value="{{ old('name') ? old('name') : $data->name }}" maxlength="25">
                                @error('name') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                            <div class="form-group">
                                <label for="description">Short description <span class="text-muted">(Optional)</span></label>
                                <textarea name="description" id="description" class="form-control" placeholder="Enter short description" rows="4">{{ old('description') ? old('description') : $data->description }}</textarea>
                                @error('description') <p class="small text-danger">{{ $message }}</p> @enderror
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
