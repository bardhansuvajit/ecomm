@extends('admin.layout.app')

@php
    if (request()->is('admin/product/setup/category')) {
        $disabledClass = "disabled";
        $saveAsDraftRoute = "";
        
        $categoryRoute = $titleRoute = $priceRoute = $imageRoute = $highlightRoute = $descriptionRoute = $usageRoute = $boxitemRoute = $ingredientRoute = $seoRoute = $variationRoute = "javascript: void(0)";
    } else {
        $disabledClass = "";
        $saveAsDraftRoute = route('admin.product.save.draft', $data->id);

        $categoryRoute = route('admin.product.setup.category.edit', $request->id);
        $titleRoute = route('admin.product.setup.title', $request->id);
        $priceRoute = route('admin.product.setup.price', $request->id);
        $imageRoute = route('admin.product.setup.images', $request->id);
        $highlightRoute = route('admin.product.setup.highlights', $request->id);
        $descriptionRoute = route('admin.product.setup.description', $request->id);
        $usageRoute = route('admin.product.setup.usage', $request->id);
        $boxitemRoute = route('admin.product.setup.boxitem', $request->id);
        $ingredientRoute = route('admin.product.setup.ingredient', $request->id);
        $seoRoute = route('admin.product.setup.seo', $request->id);
        $variationRoute = route('admin.product.setup.variation', $request->id);
    }
@endphp

@section('section')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                @if ($disabledClass != "disabled")
                                <div class="d-flex">
                                    <div class="image-holder mr-3">
                                        <a href="{{ route('admin.product.detail', $data->id) }}">
                                        @if (count($data->frontImageDetails) > 0)
                                            <img src="{{ asset($data->frontImageDetails[0]->img_large) }}" style="height:50px">
                                        @else
                                            {{-- <img src="{{ asset('frontend-assets/img/logo.png') }}" style="height:50px"> --}}
                                        @endif
                                        </a>
                                    </div>
                                    <div class="other-details">
                                        @if ($data->title)
                                            <p class="text-muted mb-1"><a href="{{ route('admin.product.detail', $data->id) }}">{{ $data->title }}</a></p>
                                        @endif
                                        {!! productCategories($data->id, 1, 'horizontal') !!}
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="col-md-6 text-right">
                                <a href="{{ $saveAsDraftRoute }}" class="btn btn-sm btn-primary {{ $disabledClass }}"> <i class="fa fa-save"></i> Save as Draft</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        <ul class="nav nav-pills">
                            <li class="nav-item">
                                <a class="nav-link {{ $disabledClass }} {{ ( request()->is('admin/product/setup/category') || request()->is('admin/product/setup/category/edit*') ) ? 'active' : '' }}" href="{{ $categoryRoute }}">Category</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $disabledClass }} {{ request()->is('admin/product/setup/title*') ? 'active' : '' }}" href="{{ $titleRoute }}">Title</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $disabledClass }} {{ request()->is('admin/product/setup/price*') ? 'active' : '' }}" href="{{ $priceRoute }}">Price</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $disabledClass }} {{ request()->is('admin/product/setup/images*') ? 'active' : '' }}" href="{{ $imageRoute }}">Images</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $disabledClass }} {{ request()->is('admin/product/setup/highlights*') ? 'active' : '' }}" href="{{ $highlightRoute }}">Highlights</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $disabledClass }} {{ request()->is('admin/product/setup/description*') ? 'active' : '' }}" href="{{ $descriptionRoute }}">Description</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $disabledClass }} {{ request()->is('admin/product/setup/usage*') ? 'active' : '' }}" href="{{ $usageRoute }}">Usage</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $disabledClass }} {{ request()->is('admin/product/setup/box-item*') ? 'active' : '' }}" href="{{ $boxitemRoute }}">Box item</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $disabledClass }} {{ request()->is('admin/product/setup/ingredient*') ? 'active' : '' }}" href="{{ $ingredientRoute }}">Ingredient</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $disabledClass }} {{ request()->is('admin/product/setup/seo*') ? 'active' : '' }}" href="{{ $seoRoute }}">SEO</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $disabledClass }} {{ request()->is('admin/product/setup/variation*') ? 'active' : '' }}" href="{{ $variationRoute }}">Variation</a>
                            </li>
                        </ul>

                        <hr>

                        @yield('product-setup')

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection