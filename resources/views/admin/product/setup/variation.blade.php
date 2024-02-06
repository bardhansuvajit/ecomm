@extends('admin.layout.app-product-setup')
@section('page-title', 'Product - Variation')

@section('product-setup')
@if (count($data->variationParents) > 0)
<div class="row mb-3">
    <div class="col-md-12 text-right">
        <button data-target="#createVariationModal" data-toggle="modal" class="btn btn-primary btn-sm"> <i class="fas fa-plus"></i> Create new</button>
    </div>
</div>

<div class="row">
    @foreach ($data->variationParents as $item)
    <div class="col-md-12">
        <div class="card shadow-none border">
            <div class="card-body">
                <div class="row">
                    <div class="col-10">
                        <h5 class="{{ (count($item->frontVariationChildern) == 0) ? 'text-danger font-weight-bold' : '' }} ">{{$item->title}}</h5>

                        @if ((count($item->frontVariationChildern) == 0))
                            <p class="small card-text">No variations found under <i>{{$item->title}}</i>. It will not be displayed in Frontend. <a href="{{ route('admin.product.setup.variation.child.create', [$data->id, $item->id]) }}">Add new</a></p>
                        @endif

                        <div class="btn-group">
                            @foreach ($item->frontVariationChildern as $index => $child_variation)
                                <input type="radio" class="btn-check" id="child-var-btn-{{$index}}" value="{{ $child_variation->id }}" name="child-var_id">
                                <label class="btn btn-light" for="child-var-btn-{{$index}}">
                                    @if ($child_variation->image_medium)
                                        <img src="{{ asset($child_variation->image_medium) }}" alt="image" class="variation-image">
                                        <br>
                                    @endif
                                    {{ $child_variation->title }}
                                </label>
                            @endforeach
                        </div>

                        @if ((count($item->frontVariationChildern) > 0))
                            <p class="small text-muted">Go to <a href="{{ route('admin.product.setup.variation.parent.detail', [$data->id, $item->id]) }}">details</a> to edit, delete & change position</p>
                        @endif
                    </div>
                    <div class="col-2 text-right">
                        <div class="btn-group">
                            <a href="{{ route('admin.product.setup.variation.child.create', [$data->id, $item->id]) }}" class="btn btn-sm btn-dark" data-toggle="tooltip" title="Create">
                                <i class="fa fa-plus"></i>
                            </a>

                            <a href="{{ route('admin.product.setup.variation.parent.detail', [$data->id, $item->id]) }}" class="btn btn-sm btn-dark" data-toggle="tooltip" title="Detail">
                                <i class="fa fa-eye"></i>
                            </a>

                            <a href="{{ route('admin.product.setup.variation.parent.edit', [$data->id, $item->id]) }}" class="btn btn-sm btn-dark" data-toggle="tooltip" title="Edit">
                                <i class="fa fa-edit"></i>
                            </a>

                            <a href="{{ route('admin.product.setup.variation.parent.delete', $item->id) }}" class="btn btn-sm btn-dark" onclick="return confirm('Are you sure ?')" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure ?')">
                                <i class="fa fa-trash"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="row mb-3">
    <div class="col-md-12 text-center">
        <p class="small text-muted my-5">No variations found...</p>
        <button data-target="#createVariationModal" data-toggle="modal" class="btn btn-primary btn-sm"> <i class="fas fa-plus"></i> Create new</button>
    </div>
</div>
@endif


<div id="createVariationModal" class="modal fade" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add new variation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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