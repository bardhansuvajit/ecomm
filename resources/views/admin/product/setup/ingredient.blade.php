@extends('admin.layout.app-product-setup')
@section('page-title', 'Product - Ingredient')

@section('product-setup')
<form action="{{ route('admin.product.setup.store.ingredient') }}" method="post" enctype="multipart/form-data">@csrf

    <div class="form-group row">
        <div class="col-md-6">
            <label for="image">Image <span class="text-muted">(Optional)</span></label>
            <input type="file" name="image" id="image" class="form-control">
            @error('image') <p class="small text-danger">{{ $message }}</p> @enderror
        </div>
        <div class="col-md-6">
            <label for="title">Title <span class="text-muted">*</span></label>
            <input type="text" name="title" id="title" class="form-control" placeholder="Instruction title" value="{{ old('title') }}" autofocus>
            @error('title') <p class="small text-danger">{{ $message }}</p> @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-12">
            <label for="details">Detailed instruction <span class="text-muted">(Optional)</span></label>
            <textarea name="details" id="details" class="form-control" placeholder="Enter instruction details">{{ old('details') }}</textarea>
            @error('details') <p class="small text-danger">{{ $message }}</p> @enderror
        </div>
    </div>

    <input type="hidden" name="product_id" value="{{ $request->id }}">
    <button type="submit" class="btn btn-primary">Save &amp; Next</button>
</form>

@if (!empty($data->ingredientDetails) && count($data->ingredientDetails) > 0)
    <hr>

    <div class="row">
        <div class="col-md-6">
            <p class="text-muted">Uploaded ingredients: {{ count($data->ingredientDetails) }} </p>
        </div>
        <div class="col-md-6 text-right">
            <p class="small text-muted text-right">Drag &amp; drop table content to re-order their position</p>
        </div>
    </div>

    <table class="table table-sm table-hover mb-3">
        <thead>
            <tr>
                <th style="width: 10px">#</th>
                <th>Ingredient</th>
                <th style="width: 100px">Action</th>
            </tr>
        </thead>
        <tbody class="sortable" data-position-update-route="{{ route('admin.product.setup.ingredient.position') }}" data-csrf-token="{{ csrf_token() }}">
            @foreach ($data->ingredientDetails as $index => $item)
                <tr class="single" id="{{ $item->id }}">
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <div class="d-flex">
                            @if (!empty($item->image_medium) && file_exists(public_path($item->image_medium)))
                                <img src="{{ asset($item->image_medium) }}" alt="image" class="mr-3" style="height: 50px">
                            @endif

                            <div class="details">
                                <p class="mb-1">{{ $item->title }}</p>
                                <p class="small text-muted">{{ $item->details }}</p>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex">
                            <div class="custom-control custom-switch mt-1" data-bs-toggle="tooltip" title="Toggle status">
                                <input type="checkbox" class="custom-control-input" id="customSwitch{{$item->id}}" {{ ($item->status == 1) ? 'checked' : '' }} onchange="statusToggle('{{ route('admin.product.setup.ingredient.status', $item->id) }}')">
                                <label class="custom-control-label" for="customSwitch{{$item->id}}"></label>
                            </div>
    
                            <div class="btn-group">
                                <a href="{{ route('admin.product.setup.ingredient.delete', $item->id) }}" class="btn btn-sm btn-dark" onclick="return confirm('Are you sure ?')" data-bs-toggle="tooltip" title="Delete">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
@endsection