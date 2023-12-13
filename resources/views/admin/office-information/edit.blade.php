@extends('admin.layout.app')
@section('page-title', 'Edit office information')

@section('section')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row mb-3">
                            <div class="col-md-12 text-right">
                                <a href="{{ route('admin.office.information.detail') }}" class="btn btn-sm btn-primary"> <i class="fa fa-chevron-left"></i> Back</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.office.information.update') }}" method="post" enctype="multipart/form-data">@csrf
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="full_name">Full name <span class="text-muted">*</span></label>
                                    <input type="text" class="form-control" name="full_name" id="full_name" placeholder="" value="{{ old('full_name') ? old('full_name') : $data->full_name }}">
                                    @error('full_name') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="pretty_name">Pretty name <span class="text-muted">*</span></label>
                                    <input type="text" class="form-control" name="pretty_name" id="pretty_name" placeholder="" value="{{ old('pretty_name') ? old('pretty_name') : $data->pretty_name }}">
                                    @error('pretty_name') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="short_desc">Short description <span class="text-muted">(Optional)</span></label>
                                <textarea name="short_desc" id="short_desc" class="form-control" placeholder="">{{ old('short_desc') ? old('short_desc') : $data->short_desc }}</textarea>
                                @error('short_desc') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                            <div class="form-group">
                                <label for="detailed_desc">Detailed description <span class="text-muted">(Optional)</span></label>
                                <textarea name="detailed_desc" id="detailed_desc" class="form-control" placeholder="">{{ old('detailed_desc') ? old('detailed_desc') : $data->detailed_desc }}</textarea>
                                @error('detailed_desc') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                            <hr class="bg-dark">

                            <div class="row form-group">
                                <div class="col-md-4">
                                    @if (!empty($data->primary_logo))
                                        @if (!empty($data->primary_logo) && file_exists(public_path($data->primary_logo)))
                                            <img src="{{ asset($data->primary_logo) }}" class="img-thumbnail" style="height: 50px">
                                        @else
                                            <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" style="height: 50px">
                                        @endif
                                        <br>
                                    @endif

                                    <label for="primary_logo">Primary logo</label>
                                    <input type="file" class="form-control" name="primary_logo" id="primary_logo">
                                    {!! imageUploadNotice('company-primary-logo')['html'] !!}
                                    @error('primary_logo') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>

                                <div class="col-md-4">
                                    @if (!empty($data->hq_logo))
                                        @if (!empty($data->hq_logo) && file_exists(public_path($data->hq_logo)))
                                            <img src="{{ asset($data->hq_logo) }}" class="img-thumbnail" style="height: 50px">
                                        @else
                                            <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" style="height: 50px">
                                        @endif
                                        <br>
                                    @endif

                                    <label for="hq_logo">High quality logo</label>
                                    <input type="file" class="form-control" name="hq_logo" id="hq_logo">
                                    {!! imageUploadNotice('company-hd-logo')['html'] !!}
                                    @error('hq_logo') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>

                                <div class="col-md-4">
                                    @if (!empty($data->watermark_logo))
                                        @if (!empty($data->watermark_logo) && file_exists(public_path($data->watermark_logo)))
                                            <img src="{{ asset($data->watermark_logo) }}" class="img-thumbnail" style="height: 50px">
                                        @else
                                            <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" style="height: 50px">
                                        @endif
                                        <br>
                                    @endif

                                    <label for="watermark_logo">Watermark logo</label>
                                    <input type="file" class="form-control" name="watermark_logo" id="watermark_logo">
                                    {!! imageUploadNotice('company-watermark-logo')['html'] !!}
                                    @error('watermark_logo') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <hr class="bg-dark">

                            <div class="row form-group">
                                <div class="col-md-4">
                                    @if (!empty($data->rectangle_logo))
                                        @if (!empty($data->rectangle_logo) && file_exists(public_path($data->rectangle_logo)))
                                            <img src="{{ asset($data->rectangle_logo) }}" class="img-thumbnail" style="height: 50px">
                                        @else
                                            <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" style="height: 50px">
                                        @endif
                                        <br>
                                    @endif

                                    <label for="rectangle_logo">Rectangle logo</label>
                                    <input type="file" class="form-control" name="rectangle_logo" id="rectangle_logo">
                                    {!! imageUploadNotice('company-rectangle-logo')['html'] !!}
                                    @error('rectangle_logo') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>

                                <div class="col-md-4">
                                    @if (!empty($data->square_logo))
                                        @if (!empty($data->square_logo) && file_exists(public_path($data->square_logo)))
                                            <img src="{{ asset($data->square_logo) }}" class="img-thumbnail" style="height: 50px">
                                        @else
                                            <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" style="height: 50px">
                                        @endif
                                        <br>
                                    @endif

                                    <label for="square_logo">Square logo</label>
                                    <input type="file" class="form-control" name="square_logo" id="square_logo">
                                    {!! imageUploadNotice('company-square-logo')['html'] !!}
                                    @error('square_logo') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>

                                <div class="col-md-4">
                                    @if (!empty($data->favicon))
                                        @if (!empty($data->favicon) && file_exists(public_path($data->favicon)))
                                            <img src="{{ asset($data->favicon) }}" class="img-thumbnail" style="height: 50px">
                                        @else
                                            <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" style="height: 50px">
                                        @endif
                                        <br>
                                    @endif

                                    <label for="favicon">Favicon</label>
                                    <input type="file" class="form-control" name="favicon" id="favicon">
                                    {!! imageUploadNotice('company-fav-icon')['html'] !!}
                                    @error('favicon') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
