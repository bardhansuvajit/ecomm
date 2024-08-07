@extends('admin.layout.app-product-setup')
@section('page-title', 'Product - Variation')

@section('product-setup')
<div class="row mb-3">
    <div class="col-md-6">
        <ul class="nav nav-underline">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.product.setup.variation.index', $request->id) }}">List</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="{{ url()->current() }}">Position</a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" href="#">Trash</a>
            </li>
        </ul>
    </div>
    <div class="col-md-6 text-right">
        <a href="{{ route('admin.product.setup.variation.create', $request->id) }}" class="btn btn-primary btn-sm">
            <i class="fa fa-cog"></i> Set variation
        </a>
    </div>
</div>

<div class="row">
    @if (count($data->variationOptions) > 0)
        @php
            $groupedVariations = $data->variationOptions->groupBy(function ($option) {
                return $option->variationOption->variation_id;
            });
        @endphp

        <div class="col-12">
            <table class="table table-sm table-hover mb-3">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Name</th>
                        <th>Variation</th>
                        <th>Category</th>
                        <th>Datetime</th>
                        <th style="width: 100px">Action</th>
                    </tr>
                </thead>
                <tbody class="sortable" data-position-update-route="{{ route('admin.product.setup.variation.position.update', $request->id) }}" data-csrf-token="{{ csrf_token() }}">
                    @foreach ($groupedVariations as $options)
                        @foreach ($options as $index => $option)
                            <tr class="single" id="{{ $option->id }}">
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if (!empty($option->thumb_path) && file_exists($option->thumb_path))
                                        <img src="{{ asset($option->thumb_path) }}" style="height: 50px" class="">
                                    @endif

                                    {{ $option->variationOption->value }}
                                </td>
                                <td>{{ $option->variationOption->parent->title }}</td>
                                <td>{{ $option->variationOption->category }}</td>
                                <td>{{ h_date($option->created_at) }}</td>
                                <td>
                                    <div class="d-flex">
                                        <div class="custom-control custom-switch" data-bs-toggle="tooltip" title="Toggle status">
                                            <input type="checkbox" class="custom-control-input" id="customSwitch{{$option->id}}" {{ ($option->status == 1) ? 'checked' : '' }} onchange="statusToggle('{{ route('admin.product.setup.variation.status', $option->id) }}')">
                                            <label class="custom-control-label" for="customSwitch{{$option->id}}"></label>
                                        </div>

                                        <div class="btn-group">
                                            <a href="{{ route('admin.product.setup.variation.detail', [$request->id, $option->id]) }}" class="btn btn-sm btn-dark" data-toggle="tooltip" title="View">
                                                <i class="fa fa-eye"></i>
                                            </a>

                                            <a href="{{ route('admin.product.setup.variation.delete', [$request->id, $option->id]) }}" class="btn btn-sm btn-dark" onclick="return confirm('Are you sure ?')" data-toggle="tooltip" title="Delete">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="col-12 text-center my-5">
            <p class="text-muted my-5">No data added yet</p>
        </div>
    @endif
</div>
@endsection

@section('script')
    <script>

    </script>
@endsection