@extends('admin.layout.app-product-setup')
@section('page-title', 'Product - Variation parent position')

@section('product-setup')
@if (count($data->variationParents) > 0)
    <div class="row mb-3">
        <div class="col-md-10">
            <h5 class="text-primary">Variations under <strong><i>{{ $data->title }}</i></strong></h5>
            <p class="small text-muted">Drag &amp; drop table content to re-order their position</p>
        </div>
        <div class="col-md-2 text-right">
            <a href="{{ route('admin.product.setup.variation', $data->id) }}" class="btn btn-primary btn-sm"> <i class="fa fa-chevron-left"></i> Back</a>
        </div>
    </div>

    <div class="row sortable" data-position-update-route="{{ route('admin.product.setup.variation.parent.position.update', [$request->id, $request->id]) }}" data-csrf-token="{{ csrf_token() }}">
        @foreach ($data->variationParents as $item)
        <div class="col-md-2 single" id="{{ $item->id }}">
            <div class="card shadow-none border {{ ($item->status == 0) ? 'bg-inactive' : '' }}">
                <div class="card-body">
                    {{-- <div class="row">
                        <div class="col-12"> --}}
                            <div class="d-flex justify-content-between">
                                <h5 class="{{ (count($item->frontVariationChildern) == 0) ? 'text-danger font-weight-bold' : '' }} ">{{$item->title}}</h5>

                                <div class="btn-group">
                                    <div class="custom-control custom-switch mt-1" data-bs-toggle="tooltip" title="Toggle status">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch{{$item->id}}" {{ ($item->status == 1) ? 'checked' : '' }} onchange="statusToggle('{{ route('admin.product.setup.variation.child.status', $item->id) }}')">
                                        <label class="custom-control-label" for="customSwitch{{$item->id}}"></label>
                                    </div>
                                </div>
                            </div>

                            @if ((count($item->frontVariationChildern) == 0))
                                <p class="small card-text">No variations found under <i>{{$item->title}}</i>. It will not be displayed in Frontend. <a href="{{ route('admin.product.setup.variation.child.create', [$data->id, $item->id]) }}">Add new</a></p>
                            @endif

                            @foreach ($item->frontVariationChildern as $index => $child_variation)
                                <span class="badge bg-dark" for="child-var-btn-{{$index}}">
                                    @if ($child_variation->image_medium)
                                        <img src="{{ asset($child_variation->image_medium) }}" alt="image" class="variation-image">
                                        <br>
                                    @endif
                                    {{ $child_variation->title }}
                                </span>
                            @endforeach

                            @if ((count($item->frontVariationChildern) > 0))
                                <p class="small text-muted mt-2">Go to <a href="{{ route('admin.product.setup.variation.parent.detail', [$data->id, $item->id]) }}">details</a> to edit, delete & change position</p>
                            @endif
                        {{-- </div>
                    </div> --}}
                </div>
            </div>
        </div>
        @endforeach
    </div>
@else
    <div class="row mb-3">
        <div class="col-md-12 text-center">
            <p class="small text-muted my-5">No variations found...</p>
            <button data-bs-target="#createVariationModal" data-bs-toggle="modal" class="btn btn-primary btn-sm"> <i class="fas fa-plus"></i> Create new</button>
        </div>
    </div>
@endif


<div id="createVariationModal" class="modal fade" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add new variation</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.product.setup.store.variation.parent') }}" method="post">@csrf
                    <div class="form-group">
                        <label for="title">Variation title <span class="text-muted">(Optional)</span></label>
                        <textarea name="title" id="title" class="form-control" placeholder="Enter Variation title">{{ old('title') }}</textarea>
                        @error('title') <p class="small text-danger">{{ $message }}</p> @enderror
                    </div>

                    <input type="hidden" name="product_id" value="{{ $request->id }}">
                    <button type="submit" class="btn btn-primary">Save &amp; Upload</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        $('#createVariationModal').on('shown.bs.modal', function (event) {
            setTimeout(() => {
                $('textarea[name="title"]').focus();
            }, 200);
        });

        // var hash = document.URL.substr(document.URL.indexOf('#')+1)
        // alert(hash)
        // $('#createVariationModal').modal('show')
    </script>
@endsection