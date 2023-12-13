@extends('admin.layout.app')
@section('page-title', 'Product feature list')

@section('section')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 text-center">
                                <h5 class="font-weight-bold text-primary">Featured Product list</h5>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-12">
                                <form action="" method="get">
                                    <div class="d-flex justify-content-end">
                                        <div class="form-group ml-2">
                                            <input type="search" class="form-control form-control-sm" name="featuredProductKeyword" id="featuredProductKeyword" value="" placeholder="Search something..." onkeyup="fetchFeaturedProducts()">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 text-center">
                                <div id="featuredProducts">
                                    <p class="text-muted my-5">Loading...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 text-center">
                                <h5 class="font-weight-bold text-primary">All Products</h5>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-12">
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
                            </div>
                        </div>
                        <div class="row">
                            @if (count($productList) > 0)
                            <div class="col-md-12">
                                <table class="table table-sm table-striped table-hover">
                                    <tbody>
                                        @foreach ($productList as $index => $product)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" class="mr-2" id="customCheck{{$index}}" onchange="addToFeatureProduct({{ $product->id }})" {{ (collect($productFeatures)->contains($product->id)) ? 'checked' : '' }}>
                                                </td>
                                                <td>
                                                    <label for="customCheck{{$index}}">
                                                    <div class="media">
                                                        @if (count($product->frontImageDetails) > 0)
                                                            <img src="{{ asset($product->frontImageDetails[0]->img_large) }}" alt="image" class="img-thumbnail mr-3" style="height: 70px">
                                                        @else
                                                            <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" alt="image" class="img-thumbnail mr-3" style="height: 70px">
                                                        @endif
                                                        {{-- <img src="{{ asset($product->image_small) }}" alt="image" class="img-thumbnail mr-3" style="height: 70px"> --}}

                                                        <div class="media-body">
                                                            <a href="{{ route('admin.product.detail', $product->id) }}" target="_blank"><p class="text-muted mb-2">{{ $product->title }}</p></a>

                                                            <p class="text-muted small height-2">
                                                                {{ $product->short_desc }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    </label>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div class="pagination-container">
                                    {{$productList->appends($_GET)->links()}}
                                </div>
                            </div>
                            @else
                            <div class="col-md-12 text-center">
                                <p class="text-muted my-5">No data yet...</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
    <script>
        function fetchFeaturedProducts() {
            $.ajax({
                url: "{{route('product.featured.fetch')}}",
                method: 'post',
                data: {
                    _token: "{{csrf_token()}}",
                    keyword: $('input[name="featuredProductKeyword"]').val()
                },
                success: function(result) {
                    let content = '';

                    if (result.status == 200) {
                        content += `<div class="row sortable" data-position-update-route="{{ route('admin.product.feature.position') }}" data-csrf-token="{{ csrf_token() }}">`;

                        $.each(result.data, (key, value) => {
                            var shortDesc = '';
                            if (value.short_desc) {
                                shortDesc = value.short_desc;
                            }

                            content += `
                            <div class="col-md-4 single" id="${value.feature_id}">
                                <div class="card text-left">
                                    <img class="card-img-top" src="${value.image}" alt="image">
                                    <div class="card-body p-2">
                                        <a href="${value.link}" target="_blank"><p class="text-muted mb-2">${value.title}</p></a>
                                        <p class="text-muted small height-2">${shortDesc}</p>
                                    </div>
                                </div>
                            </div>
                            `;
                        });
                    } else {
                        content += `<p class="text-muted my-5">No data yet...</p>`;
                    }

                    $('#featuredProducts').html(content);

                    // jquery UI sortable calling again
                    // as not working on ajax load
                    $( ".sortable" ).sortable({
                        delay: 150,
                        stop: function() {
                            var selectedData = new Array();
                            var route = $(this).attr('data-position-update-route');
                            var token = $(this).attr('data-csrf-token');
                            $('.sortable > .single').each(function() {
                                selectedData.push($(this).attr('id'));
                            });
                            updatePosition(selectedData, route, token);
                        }
                    });
                }
            });
        }

        function addToFeatureProduct(productId) {
            $.ajax({
                url: "{{route('product.featured.add')}}",
                method: 'post',
                data: {
                    _token: "{{csrf_token()}}",
                    product_id: productId,
                },
                beforeSend: function() {
                    toastFire('info', 'Please wait...');
                },
                success: function(result) {
                    toastFire('success', result.message);
                    if (result.status == 200) {
                        fetchFeaturedProducts();
                    }
                }
            });
        }

        fetchFeaturedProducts();
    </script>
@endsection
