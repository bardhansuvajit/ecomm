@extends('admin.layout.app')
@section('page-title', 'Service list')

@section('section')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row mb-3">
                            <div class="col-md-12 text-right">
                                <a href="{{ route('admin.service.create') }}" class="btn btn-sm btn-primary"> <i class="fa fa-plus"></i> Create</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="small text-muted font-weight-bold">Showing {{$data->firstItem()}}-{{$data->lastItem()}} out of {{$data->total()}}</p>
                            </div>
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
                                                <a href="{{ url()->current() }}" class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="Clear filter">
                                                    <i class="fa fa-times"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Description</th>
                                    <th style="width: 100px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $index => $item)
                                    <tr>
                                        <td>{{ $index + $data->firstItem() }}</td>
                                        <td>
                                            @if (!empty($item->image_small) && file_exists(public_path($item->image_small)))
                                                <img src="{{ asset($item->image_small) }}" alt="image" style="height: 50px" class="img-thumbnail mr-2">
                                            @else
                                                <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" alt="image" style="height: 50px" class="mr-2">
                                            @endif
                                            {{ $item->title }}
                                        </td>
                                        <td>
                                            @if ($item->categoryDetails)
                                                {{ $item->categoryDetails->title }}
                                            @endif

                                            @if ($item->subCategoryDetails)
                                                <br>
                                                {{ $item->subCategoryDetails->title }}
                                            @endif
                                        </td>
                                        <td>
                                            @if (!empty($item->short_desc))
                                                <p class="small text-muted mb-0">
                                                    {{ $item->short_desc }}
                                                </p>
                                            @else
                                                <p class="text-muted mb-0">NA</p>
                                            @endif
                                        </td>
                                        <td class="d-flex">
                                            <div class="custom-control custom-switch mt-1" data-bs-toggle="tooltip" title="Toggle status">
                                                <input type="checkbox" class="custom-control-input" id="customSwitch{{$item->id}}" {{ ($item->status == 1) ? 'checked' : '' }} onchange="statusToggle('{{ route('admin.service.status', $item->id) }}')">
                                                <label class="custom-control-label" for="customSwitch{{$item->id}}"></label>
                                            </div>

                                            <div class="btn-group">
                                                <a href="{{ route('admin.service.detail', $item->id) }}" class="btn btn-sm btn-dark" data-bs-toggle="tooltip" title="View">
                                                    <i class="fa fa-eye"></i>
                                                </a>

                                                <a href="{{ route('admin.service.edit', $item->id) }}" class="btn btn-sm btn-dark" data-bs-toggle="tooltip" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>

                                                <a href="{{ route('admin.service.delete', $item->id) }}" class="btn btn-sm btn-dark" onclick="return confirm('Are you sure ?')" data-bs-toggle="tooltip" title="Delete">
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