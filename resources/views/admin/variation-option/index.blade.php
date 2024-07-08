@extends('admin.layout.app')
@section('page-title', 'Variation option')

@section('section')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row mb-3">
                            <div class="col-md-12 text-right">
                                <a href="{{ route('admin.product.variation.option.create') }}" class="btn btn-sm btn-primary"> <i class="fa fa-plus"></i> Create</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                @if (count($data) > 0)
                                    <p class="small text-muted font-weight-bold">Showing {{$data->firstItem()}}-{{$data->lastItem()}} out of {{$data->total()}}</p>
                                @endif

                                <ul class="nav nav-underline">
                                    <li class="nav-item">
                                        <a class="nav-link active" aria-current="page" href="{{ url()->current() }}">List</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.product.variation.option.position') }}">Position</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link disabled" href="#">Trash</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <form action="" method="get">
                                    <div class="d-flex justify-content-end">
                                        <div class="form-group ml-2">
                                            <select name="variation" id="variation" class="form-select form-select-sm" style="width: 150px;">
                                                <option value="">Select variation...</option>
                                                <option value="" {{ (request()->input('variation') === null || request()->input('variation') === '') ? 'selected' : '' }}>All</option>
                                                @foreach ($variations['data'] as $parent)
                                                    <option value="{{ $parent->id }}" {{ (request()->input('variation') == $parent->id) ? 'selected' : '' }}>{{ $parent->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group ml-2">
                                            <select name="category" id="category" class="form-select form-select-sm" style="width: 150px;">
                                                <option value="">Select category...</option>
                                                @foreach ($categories['data'] as $category)
                                                    <option value="{{ $category }}" {{ (request()->input('category') == $category) ? 'selected' : '' }}>{{ ucwords($category) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group ml-2">
                                            <select name="status" id="status" class="form-select form-select-sm" style="width: 150px;">
                                                <option value="">Select status...</option>
                                                <option value="" {{ (request()->input('status') === null || request()->input('status') === '') ? 'selected' : '' }}>All</option>
                                                <option value="1" {{ (request()->input('status') == '1') ? 'selected' : '' }}>Active</option>
                                                <option value="0" {{ (request()->input('status') == '0') ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </div>
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
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-hover mb-3">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Equivalent</th>
                                    <th>Information</th>
                                    <th>Datetime</th>
                                    <th style="width: 100px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $index => $item)
                                    <tr>
                                        <td>{{ $index + $data->firstItem() }}</td>
                                        <td>
                                            <p class="text-dark mb-0">{{ $item->value }}</p>
                                            <p class="small text-muted mb-0">{{ $item->parent->title }}</p>
                                        </td>
                                        <td>
                                            <p class="mb-0">{{ $item->category }}</p>
                                        </td>
                                        <td>
                                            <p class="small text-small mb-0">{{ $item->equivalent }}</p>
                                        </td>
                                        <td>
                                            <p class="small text-small mb-0">{{ $item->information }}</p>
                                        </td>
                                        <td>
                                            <p class="small text-muted">
                                                {{ h_date($item->created_at) }}
                                            </p>
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                <div class="custom-control custom-switch mt-1" data-toggle="tooltip" title="Toggle status">
                                                    <input type="checkbox" class="custom-control-input" id="customSwitch{{$item->id}}" {{ ($item->status == 1) ? 'checked' : '' }} onchange="statusToggle('{{ route('admin.product.variation.option.status', $item->id) }}')">
                                                    <label class="custom-control-label" for="customSwitch{{$item->id}}"></label>
                                                </div>

                                                <div class="btn-group">
                                                    <a href="{{ route('admin.product.variation.option.detail', $item->id) }}" class="btn btn-sm btn-dark" data-toggle="tooltip" title="View">
                                                        <i class="fa fa-eye"></i>
                                                    </a>

                                                    <a href="{{ route('admin.product.variation.option.edit', $item->id) }}" class="btn btn-sm btn-dark" data-toggle="tooltip" title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </a>

                                                    <a href="{{ route('admin.product.variation.option.delete', $item->id) }}" class="btn btn-sm btn-dark" onclick="return confirm('Are you sure ?')" data-toggle="tooltip" title="Delete">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </div>
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
                            @if (count($data) > 0)
                                {{$data->appends($_GET)->links()}}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection