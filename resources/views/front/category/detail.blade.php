@extends('front.layout.app')

@section('content')
<div class="row justify-content-center">
    {{-- <div class="col-md-3">
        <section id="filter" class="pb-0">
            <form action="" method="get">
                <div id="title">
                    <h5>Filter</h5>
                </div>

                <div id="subtitle">
                    <p class="small text-muted">Showing 25 out of 253 products</p>
                </div>

                <div id="set-1" class="filter-set">
                    <p class="text-dark fw-semibold mb-1 set-heading">Sort by</p>

                    <input type="radio" class="btn-check" name="sort-by" id="sort-by-popularity" autocomplete="off" value="popularity-desc" {{ ( (request()->input('sort-by') == "popularity-desc") || empty(request()->input('sort-by')) ) ? 'checked' : '' }}>
                    <label class="btn btn-xsm btn-outline-dark mb-2" for="sort-by-popularity">Popularity</label>

                    <input type="radio" class="btn-check" name="sort-by" id="sort-by-price-asc" autocomplete="off" value="price-asc" {{ (request()->input('sort-by') == "price-asc") ? 'checked' : '' }}>
                    <label class="btn btn-xsm btn-outline-dark mb-2" for="sort-by-price-asc">Price Low to High</label>

                    <input type="radio" class="btn-check" name="sort-by" id="sort-by-price-desc" autocomplete="off" value="price-desc" {{ (request()->input('sort-by') == "price-desc") ? 'checked' : '' }}>
                    <label class="btn btn-xsm btn-outline-dark mb-2" for="sort-by-price-desc">Price High to Low</label>
                </div>

                <div id="set-2" class="filter-set">
                    <p class="text-dark fw-semibold mb-1 set-heading">Collection</p>

                    <ul class="list-group">
                        <li class="list-group-item">
                            <input class="form-check-input me-1" type="checkbox" id="collection-1" name="collection[]" value="first" {{ (collect(request()->input('collection'))->contains('first')) ? 'checked' : '' }}>
                            <label class="form-check-label" for="collection-1">First checkbox</label>
                        </li>
                        <li class="list-group-item">
                            <input class="form-check-input me-1" type="checkbox" id="collection-2" name="collection[]" value="second" {{ (collect(request()->input('collection'))->contains('second')) ? 'checked' : '' }}>
                            <label class="form-check-label" for="collection-2">Second checkbox</label>
                        </li>
                        <li class="list-group-item">
                            <input class="form-check-input me-1" type="checkbox" id="collection-3" name="collection[]" value="third" {{ (collect(request()->input('collection'))->contains('third')) ? 'checked' : '' }}>
                            <label class="form-check-label" for="collection-3">Third checkbox</label>
                        </li>
                    </ul>
                </div>

                <div id="set-3" class="filter-set">
                    <p class="text-dark fw-semibold mb-1 set-heading">Category</p>

                    <ul class="list-group">
                        @foreach ($data->productsDetails as $collectionProductsList)

                            @php
                                $category = productCategoriesFront($collectionProductsList->productDetails->id, 1);
                            @endphp

                            @if ($category)
                                <li class="list-group-item">
                                    <input class="form-check-input me-1" type="checkbox" id="category-1" name="category[]" value="first" {{ (collect(request()->input('category'))->contains('first')) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="category-1">
                                        {{ $category->title }}
                                    </label>
                                </li>
                            @endif
                        @endforeach
                        <li class="list-group-item">
                            <input class="form-check-input me-1" type="checkbox" id="category-1" name="category[]" value="first" {{ (collect(request()->input('category'))->contains('first')) ? 'checked' : '' }}>
                            <label class="form-check-label" for="category-1">First checkbox</label>
                        </li>
                        <li class="list-group-item">
                            <input class="form-check-input me-1" type="checkbox" id="category-2" name="category[]" value="second" {{ (collect(request()->input('category'))->contains('second')) ? 'checked' : '' }}>
                            <label class="form-check-label" for="category-2">Second checkbox</label>
                        </li>
                        <li class="list-group-item">
                            <input class="form-check-input me-1" type="checkbox" id="category-3" name="category[]" value="third" {{ (collect(request()->input('category'))->contains('third')) ? 'checked' : '' }}>
                            <label class="form-check-label" for="category-3">Third checkbox</label>
                        </li>
                    </ul>
                </div>

                <div style="height: 500px"></div>

                <div id="form-submit-buttons">
                    <button type="submit" class="btn btn-sm btn-dark">Apply</button>
                    <a href="{{ url()->current() }}" class="btn btn-sm btn-light">Cancel</a>
                </div>
            </form>
        </section>
    </div> --}}

    <div class="col-md-9">
        <section id="page-detail">
            <div id="breadcrumb">
                <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('front.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('front.category.index') }}">Categories</a></li>
                        {{-- @if ($type == 2) --}}
                        @if ($data->parentDetail)
                            <li class="breadcrumb-item"><a href="{{ route('front.category.detail.one', $data->parentDetail->slug) }}">{{ $data->parentDetail->title }}</a></li>
                        @endif
                        <li class="breadcrumb-item active" aria-current="page">{{ $data->title }}</li>
                    </ol>
                </nav>
            </div>

            <div id="title">
                <h5>{{ $data->title }}</h5>
            </div>

            @if ($data->short_desc)
            <div id="short-description">
                <p class="small text-muted review1 height-3 mb-0">{{ $data->short_desc }}</p>
                <a href="javascript: void(0)" onclick="seeMoreText('review1', 'more-text1')" class="more-text1">See more</a>
            </div>
            @endif

            @if ($data->detailed_desc)
            <div id="detailed-description">
                <p class="small text-muted review2 height-3 mb-0">{{ $data->detailed_desc }}</p>
                <a href="javascript: void(0)" onclick="seeMoreText('review2', 'more-text2')" class="more-text2">See more</a>
            </div>
            @endif

            @if (count($subs) > 0)
            <div id="content">
                <div class="contents-container">
                    @foreach ($subs as $subcategory)
                    <div class="single-content">
                        <div class="card">
                            <a href="{{ route('front.category.detail.two', [$data->slug, $subcategory->slug]) }}">
                                <img class="card-img-top" src="{{ asset($subcategory->icon_medium) }}" alt="{{$subcategory->slug}}">
                                <div class="card-body">
                                    <p class="card-text">{{$subcategory->title}}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <div id="products">
                <div class="row my-4">
                    @foreach ($data->productsDetails as $productCategory)
                    {{-- @foreach ($products as $product) --}}

                    @php
                        $product = $productCategory->productDetails;

                        if(!in_array($product->status, showInFrontendProductStatusID())) continue; 
                    @endphp

                    <div class="col-md-3">
                        <div class="single-product">
                            <div class="card">
                                <a href="{{ route('front.product.detail', $product->slug) }}">
                                    <div class="full-container">
                                        <div class="image-container">
                                            <div class="image-holder">
                                                @if (count($product->frontImageDetails) > 0)
                                                    <img src="{{ asset($product->frontImageDetails[0]->img_medium) }}" alt="{{ $product->slug }}">
                                                @else
                                                    <img src="{{ asset('uploads/static-front-missing-image/product.svg') }}" alt="{{ $product->slug }}" style="height: 100px">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="description-container">
                                            <div class="product-title">
                                                <h5>{{ $product->title }}</h5>
                                            </div>

                                            @if ($product->activeReviewDetails)
                                            @if (ratingCalculation(json_decode($product->activeReviewDetails, true)))
                                                <div class="rating">
                                                    <div class="rating-count">
                                                        <h5 class="digit">{{ ratingCalculation(json_decode($product->activeReviewDetails, true)) }}</h5> 
                                                        <div class="icon">
                                                            <i class="material-icons md-light">star</i>
                                                        </div>
                                                    </div>
                                                    <div class="review-count">({{ indianMoneyFormat(count($product->activeReviewDetails)) }})</div>
                                                </div>
                                            @endif
                                            @endif

                                            @php
                                                $pricing = productPricing($product);
                                            @endphp

                                            @if (!empty($pricing))
                                                <div class="pricing">
                                                    <h4 class="selling-price">
                                                        <span class="currency-icon">{!! $pricing['currency_entity'] !!}</span>
                                                        <span class="amount">{{ indianMoneyFormat($pricing['selling_price']) }}</span>
                                                    </h4>
                                                    <h6 class="mrp">
                                                        <span class="currency-icon">{!! $pricing['currency_entity'] !!}</span>
                                                        <span class="amount">{{ indianMoneyFormat($pricing['mrp']) }}</span>
                                                    </h6>
                                                </div>
                                                <div class="discount">
                                                    <span>{{discountCalculate($pricing['selling_price'], $pricing['mrp'])}}</span>
                                                    <span>off</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </a>

                                <div class="wishlist-container">
                                    @if (auth()->guard('web')->check())
                                        <button class="wishlist-btn wish-product-{{$product->id}} {{ ($product->wishlistDetail) ? 'active' : '' }}" onclick="wishlistToggle({{$product->id}})">
                                            @if ($product->wishlistDetail)
                                                <i class="material-icons">favorite</i>
                                            @else
                                                <i class="material-icons">favorite_border</i>
                                            @endif
                                        </button>
                                    @else
                                        <button class="wishlist-btn" onclick="wishlistToggle({{$product->id}})">
                                            <i class="material-icons">favorite_border</i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div id="pagination">
                
            </div>
        </section>
    </div>
</div>
@endsection