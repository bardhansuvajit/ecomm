@extends('admin.layout.app')
@section('page-title', 'User')

@section('section')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row mb-3">
                            <div class="col-md-12 text-right">
                                <a href="{{ route('admin.user.create') }}" class="btn btn-sm btn-primary"> <i class="fa fa-plus"></i> Create</a>
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
                                    <th>Name</th>
                                    <th>Contact</th>
                                    <th>Created at</th>
                                    <th style="width: 100px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $index => $item)
                                    <tr>
                                        <td>{{ $index + $data->firstItem() }}</td>
                                        <td>
                                            <p class="small text-muted mb-0">
                                                {{ $item->first_name }}
                                                {{ $item->last_name }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-muted mb-0">
                                                <small><i class="fas fa-phone fa-rotate-90 user-icons"></i> </small> 
                                                {{ $item->mobile_no }}
                                            </p>
                                            @if ($item->whatsapp_no)
                                                <p class="text-muted mb-0">
                                                    <small><i class="fab fa-whatsapp"></i> </small> 
                                                    {{ $item->whatsapp_no }}
                                                </p>
                                            @endif
                                            <p class="text-muted mb-0">
                                                <small><i class="fas fa-envelope user-icons"></i> </small> 
                                                {{ $item->email }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="small text-muted mb-0">
                                                {{ h_date($item->created_at) }}
                                            </p>
                                        </td>
                                        <td class="d-flex">
                                            <div class="custom-control custom-switch mt-1" data-bs-toggle="tooltip" title="Toggle status">
                                                <input type="checkbox" class="custom-control-input" id="customSwitch{{$item->id}}" {{ ($item->status == 1) ? 'checked' : '' }} onchange="statusToggle('{{ route('admin.user.status', $item->id) }}')">
                                                <label class="custom-control-label" for="customSwitch{{$item->id}}"></label>
                                            </div>

                                            <div class="btn-group">
                                                <a href="{{ route('admin.user.detail', $item->id) }}" class="btn btn-sm btn-dark" data-bs-toggle="tooltip" title="View">
                                                    <i class="fa fa-eye"></i>
                                                </a>

                                                <a href="{{ route('admin.user.edit', $item->id) }}" class="btn btn-sm btn-dark" data-bs-toggle="tooltip" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>

                                                <a href="{{ route('admin.user.delete', $item->id) }}" class="btn btn-sm btn-dark" onclick="return confirm('Are you sure ?')" data-bs-toggle="tooltip" title="Delete">
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