@extends('admin.layout.app')
@section('page-title', 'Banner list')

@section('section')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row mb-3">
                            <div class="col-md-12 text-right">
                                <a href="{{ route('admin.content.banner.create') }}" class="btn btn-sm btn-primary"> <i class="fa fa-plus"></i> Create</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6">
                                <form action="" method="get">
                                    <div class="d-flex justify-content-end">
                                        <div class="form-group ml-2">
                                            <input type="search" class="form-control form-control-sm" name="keyword" id="keyword" value="{{ request()->input('keyword') }}" placeholder="Search something...">
                                        </div>
                                        <div class="form-group ml-2">
                                            <div class="btn-group">
                                                <button type="submit" class="btn btn-sm btn-primary">
                                                    <i class="fa fa-filter"></i>
                                                </button>
                                                <a href="{{ url()->current() }}" class="btn btn-sm btn-light" data-toggle="tooltip" title="Clear filter">
                                                    <i class="fa fa-times"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <p class="small text-muted text-right">Drag &amp; drop table content to re-order their position</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>D Image</th>
                                    <th>M Image</th>
                                    <th>Title</th>
                                    <th style="width: 100px">Action</th>
                                </tr>
                            </thead>
                            <tbody class="sortable" data-position-update-route="{{ route('admin.content.banner.position') }}" data-csrf-token="{{ csrf_token() }}">
                                @forelse ($data as $index => $item)
                                    <tr class="single" id="{{ $item->id }}">
                                        <td>{{ $index + $data->firstItem() }}</td>
                                        <td>
                                            @if (!empty($item->desktop_image_small) && file_exists(public_path($item->desktop_image_small)))
                                                <img src="{{ asset($item->desktop_image_small) }}" alt="image" style="height: 50px" class="img-thumbnail">
                                            @else
                                                <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" alt="image" style="height: 50px" class="">
                                            @endif
                                        </td>
                                        <td>
                                            @if (!empty($item->mobile_image_small) && file_exists(public_path($item->mobile_image_small)))
                                                <img src="{{ asset($item->mobile_image_small) }}" alt="image" style="height: 50px" class="img-thumbnail">
                                            @else
                                                <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" alt="image" style="height: 50px" class="">
                                            @endif
                                        </td>
                                        <td>
                                            <div class="title-part">
                                                <p class="small text-muted mb-0">{{ $item->title1 }}</p>
                                                <p class="small text-muted mb-0">{{ $item->title2 }}</p>
                                            </div>
                                        </td>
                                        <td class="d-flex">
                                            <div class="custom-control custom-switch mt-1" data-toggle="tooltip" title="Toggle status">
                                                <input type="checkbox" class="custom-control-input" id="customSwitch{{$item->id}}" {{ ($item->status == 1) ? 'checked' : '' }} onchange="statusToggle('{{ route('admin.content.banner.status', $item->id) }}')">
                                                <label class="custom-control-label" for="customSwitch{{$item->id}}"></label>
                                            </div>

                                            <div class="btn-group">
                                                <a href="{{ route('admin.content.banner.detail', $item->id) }}" class="btn btn-sm btn-dark" data-toggle="tooltip" title="View">
                                                    <i class="fa fa-eye"></i>
                                                </a>

                                                <a href="{{ route('admin.content.banner.edit', $item->id) }}" class="btn btn-sm btn-dark" data-toggle="tooltip" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>

                                                <a href="{{ route('admin.content.banner.delete', $item->id) }}" class="btn btn-sm btn-dark" onclick="return confirm('Are you sure ?')" data-toggle="tooltip" title="Delete">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="100%" class="text-center">No records found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="pagination-container">
                            {{$data->appends($_GET)->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection