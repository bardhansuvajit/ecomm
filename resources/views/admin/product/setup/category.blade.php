@extends('admin.layout.app-product-setup')
@section('page-title', 'Product - Category')

@section('product-setup')
<form action="{{ route('admin.product.setup.store.category') }}" method="post" enctype="multipart/form-data">@csrf
    <div class="form-group">
        <label for="type">Type *</label>

        <div>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="type1" name="type" value="1" class="custom-control-input" {{ ((!old('type')) || old('type') == 1) ? 'checked' : '' }}>
                <label class="custom-control-label" for="type1">Product</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="type2" name="type" value="2" class="custom-control-input" {{ (old('type') == 2) ? 'checked' : '' }}>
                <label class="custom-control-label" for="type2">Service</label>
            </div>
        </div>

        @error('type') <p class="small text-danger">{{ $message }}</p> @enderror
    </div>

    <hr>

    <div class="form-group row">
        <div class="col-md-3">
            <label for="type">Category 1 *</label>
            <p class="small text-muted">(Multiple options can be selected)</p>

            <div class="row">
                <div class="col-md-12">
                    @if (count($activeCategories1) > 0)
                    <div class="btn-group-vertical">
                        @foreach ($activeCategories1 as $index => $cat1)
                            <input type="checkbox" class="btn-check category1s" id="btncheck1-{{$index}}" value="{{ $cat1->id }}" name="category1_id[{{$index}}]" 
                            {{ (collect(old('category1_id'))->contains($cat1->id)) ? 'checked' : '' }} 
                            onclick="fetchCategories(2)"
                            >
                            <label class="btn btn-light" for="btncheck1-{{$index}}">{{ $cat1->title }}</label>
                        @endforeach
                    </div>
                    @else
                        <p class="text-muted">No active category found</p>
                    @endif

                    @error('category1_id') <p class="small text-danger">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <label for="type">Category 2</label>
            <p class="small text-muted">(Optional)</p>
            <div class="row">
                <div class="col-md-12" id="cat2Content"></div>
            </div>
        </div>

        <div class="col-md-3">
            <label for="type">Category 3</label>
            <p class="small text-muted">(Optional)</p>
            <div class="row">
                <div class="col-md-12" id="cat3Content"></div>
            </div>
        </div>

        <div class="col-md-3">
            <label for="type">Category 4</label>
            <p class="small text-muted">(Optional)</p>
            <div class="row">
                <div class="col-md-12" id="cat4Content"></div>
            </div>
        </div>
    </div>

    <hr>

    <div class="form-group row">
        <div class="col-md-3">
            <label for="type">Collection *</label>
            <p class="small text-muted">(Multiple options can be selected)</p>

            <div class="row">
                <div class="col-md-12">
                    @if (count($activeCategories1) > 0)
                    <div class="btn-group-vertical">
                        @foreach ($activeCollections as $index => $collection)
                            <input type="checkbox" class="btn-check" id="collection-btn-{{$index}}" value="{{ $collection->id }}" name="collection_id[{{$index}}]" 
                            {{ (collect(old('collection_id'))->contains($collection->id)) ? 'checked' : '' }} 
                            >
                            <label class="btn btn-light" for="collection-btn-{{$index}}">{{ $collection->title }}</label>
                        @endforeach
                    </div>
                    @else
                        <p class="text-muted">No active collection found</p>
                    @endif

                    @error('collection_id') <p class="small text-danger">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Save &amp; Next</button>
</form>
@endsection

@section('script')
    <script>
        function fetchCategories(level) {
            let opts = [];

            if(level == 2) {
                $('.category1s').each(function () {
                    if (this.checked) {
                        opts.push($(this).val());
                    }
                });
            } else if(level == 3) {
                $('.category2s').each(function () {
                    if (this.checked) {
                        opts.push($(this).val());
                    }
                });
            } else {
                $('.category2s').each(function () {
                    if (this.checked) {
                        opts.push($(this).val());
                    }
                });
            }

            let url = "{{route('admin.product.category.fetch', ':level')}}";
            url = url.replace(':level', level);

            if (opts.length > 0) {
                $.ajax({
                    url: url,
                    method: 'post',
                    data: {
                        _token: "{{csrf_token()}}",
                        data: opts,
                    },
                    beforeSend: function() {
                        toastFire('info', 'Please wait...');
                    },
                    success: function(result) {
                        let content = '';

                        content += `<div class="btn-group-vertical">`;
                        $.each(result.data, (key, value) => {
                            if (level == 2) {
                                content += `
                                <input type="checkbox" class="btn-check category2s" id="btncheck2-${key}" value="${value.id}" name="category2_id[${key}]" onclick="fetchCategories(3)">
                                <label class="btn btn-light" for="btncheck2-${key}">${value.title}</label>
                                `;
                            } else if (level == 3) {
                                content += `
                                <input type="checkbox" class="btn-check category3s" id="btncheck3-${key}" value="${value.id}" name="category3_id[${key}]" onclick="fetchCategories(4)">
                                <label class="btn btn-light" for="btncheck3-${key}">${value.title}</label>
                                `;
                            } else {
                                content += `
                                <input type="checkbox" class="btn-check category4s" id="btncheck4-${key}" value="${value.id}" name="category4_id[${key}]">
                                <label class="btn btn-light" for="btncheck4-${key}">${value.title}</label>
                                `;
                            }
                        });
                        content += `</div>`;

                        if (level == 2) {
                            $('#cat2Content').html(content);
                        } else if (level == 3) {
                            $('#cat3Content').html(content);
                        } else {
                            $('#cat4Content').html(content);
                        }

                        swal.close()
                    }
                });
            } else {
                if (level == 2) {
                    $('#cat2Content').html('');
                } else if (level == 3) {
                    $('#cat3Content').html('');
                } else {
                    $('#cat4Content').html('');
                }
            }
        }

        @if(old('category1_id'))
            fetchCategories(2)
        @endif

        @if(old('category2_id'))
            fetchCategories(3)
        @endif

        @if(old('category3_id'))
            fetchCategories(4)
        @endif
    </script>
@endsection