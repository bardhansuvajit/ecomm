@extends('front.layout.app')

@section('style')
<link rel="stylesheet" href="{{ asset('backend-assets/plugins/ckeditor5-36.0.1-sy1shf6t1itx/content-styles.css') }}">
@endsection

@section('content')

@php
    $pricing = [];

    // if there is variation
    if (count($data->activeVariationOptions) > 0) {
        // if there is pricing
        if (!empty($data->activeVariationOptions[0]->pricing) && count($data->activeVariationOptions[0]->pricing) > 0) {
            $pricing = productVariationPricing($data, $data->activeVariationOptions[0]->id);
        } else {
            $pricing = productPricing($data);
        }
    } else {
        $pricing = productPricing($data);
    }
@endphp

<section id="primary-detail">
    <div class="row">
        <div class="col-md-5 quick-container">
            <div class="sticky-section">
                <div id="product-gallery">
                    @if (count($data->frontImageDetails) > 0)
                        <div class="swiper gallery">
                            <div class="swiper-wrapper">
                                @foreach ($data->frontImageDetails as $image)
                                <div class="swiper-slide">
                                    <div class="image-holder"><img src="{{ asset($image->img_medium) }}" alt=""/></div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="swiper thumb">
                            <div class="swiper-wrapper">
                                @foreach ($data->frontImageDetails as $image)
                                <div class="swiper-slide">
                                    <div class="image-holder"><img src="{{ asset($image->img_medium) }}" alt=""/></div>
                                </div>
                                @endforeach
                            </div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                    @else
                        <img src="{{ asset('uploads/static-front-missing-image/product.svg') }}" alt="{{ $data->slug }}" style="height: 300px">
                    @endif
                </div>

                @if (count($pricing) > 0)
                    @if ($data->statusDetail->purchase == 1)
                        <div id="purchase">
                            <div class="row g-2">
                                <div class="col-6">
                                    <div class="d-grid">
                                        <a href="javascript: void(0)" class="btn btn-lg btn-light buy-now" onclick="cartAdd('buy-now', {{$data->id}}, {{auth()->guard('web')->check() ? auth()->guard('web')->user()->id : 0}}, '{{ route('cart.add') }}')">
                                            <div class="icon"><i class="material-icons">shopping_bag</i></div>
                                            Buy now
                                        </a>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="d-grid">
                                        <a href="javascript: void(0)" class="btn btn-lg btn-dark add-cart" onclick="cartAdd('add-to-cart', {{$data->id}}, {{auth()->guard('web')->check() ? auth()->guard('web')->user()->id : 0}}, '{{ route('cart.add') }}')">
                                            Add to Cart
                                            <div class="icon"><i class="material-icons md-light">shopping_cart</i></div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div id="purchase">
                            <div class="row g-2">
                                <div class="col-12">
                                    <div class="d-grid">
                                        <a href="javascript: void(0)" class="btn btn-lg btn-light buy-now disabled">
                                            <div class="icon text-danger"><i class="material-icons fw-bolder">block</i></div>
                                            {{ $data->statusDetail->name }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>

        <div class="col-md-7 info-container">
            <div id="breadcrumb">
                <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('front.home') }}">Home</a></li>
                        @foreach ($categories as $category)
                            @if ($category->level == 1)
                                <li class="breadcrumb-item"><a href="{{ route('front.category.detail.one', $category->c1_slug) }}">{{ $category->c1_title }}</a></li>
                            @endif
                            @if ($category->level == 2)
                                <li class="breadcrumb-item"><a href="{{ route('front.category.detail.two', [$categories[0]->c1_slug, $category->c2_slug]) }}">{{ $category->c2_title }}</a></li>
                            @endif
                        @endforeach
                        <li class="breadcrumb-item active" aria-current="page">{{ $data->title }}</li>
                    </ol>
                </nav>
            </div>

            <div id="title" class="d-flex justify-content-between">
                <h5>{{ $data->title }}</h5>

                <div class="wishlist-container">
                    @if (auth()->guard('web')->check())
                        <button class="wishlist-btn wish-product-{{$data->id}} {{ ($data->wishlistDetail) ? 'active' : '' }}" onclick="wishlistToggle({{$data->id}})">
                            @if ($data->wishlistDetail)
                                <i class="material-icons">favorite</i>
                            @else
                                <i class="material-icons">favorite_border</i>
                            @endif
                        </button>
                    @else
                        <button class="wishlist-btn wish-product-{{$data->id}}" onclick="wishlistToggle({{$data->id}})">
                            <i class="material-icons">favorite_border</i>
                        </button>
                    @endif
                </div>
            </div>

            @php
                $rating = ratingCalculation(json_decode($data->activeReviewDetails, true));
            @endphp

            @if ($data->activeReviewDetails)
                @if ($rating)
                    <div id="rating">
                        <div class="ratings">
                            <div class="ratings-container">
                                <a href="#rating-details">
                                    <div class="rating-count bg-{{bootstrapRatingTypeColor($rating)}}">
                                        <h5 class="digit">{{ $rating }}</h5> 
                                        <div class="icon">
                                            <i class="material-icons md-light">star</i>
                                        </div>
                                    </div>
                                    <div class="review-count">({{ indianMoneyFormat(count($data->activeReviewDetails)) }} customer {{ (count($data->activeReviewDetails) > 1) ? 'ratings' : 'rating' }})</div>
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            @endif

            {{-- VARIATION --}}
            @if (count($data->activeVariationOptions) > 0)
                @php
                    $groupedVariations = $data->activeVariationOptions->groupBy(function ($option) {
                        return $option->variationOption->variation_id;
                    });
                @endphp

                @foreach ($groupedVariations as $vIndex => $options)
                    <div id="variation" class="mt-3">
                        <p class="small text-muted mb-2">{{ $options->first()->variationOption->parent->title }}</p>

                        <div class="btn-group variation-btn-group" role="group">
                        @foreach ($options as $optionIndex => $option)
                            <input type="radio" class="btn-check" name="prodVar{{$vIndex}}" id="prodVar{{$optionIndex}}" value="{{ $option->id }}" autocomplete="off" {{ ($optionIndex == 0) ? 'checked' : '' }}>

                            <label class="btn btn-outline-dark" for="prodVar{{$optionIndex}}" onclick="variationContent({{ $option->id }})">
                                {{ $option->variationOption->value }}

                                @if (!empty($option->tag))
                                    <span class="badge bg-danger variation-tag rounded-0">{{ $option->tag }}</span>
                                @endif
                            </label>
                        @endforeach
                        </div>

                    </div>
                @endforeach
            @endif

            {{-- PRICING --}}
            @if ($data->statusDetail->show_price_in_detail_page == 1)
                @if (count($pricing) > 0)
                <div id="pricing">
                    <div class="price-details">
                        <h4 class="selling-price display-4">
                            <span class="currency-icon">{!! $pricing['currency_entity'] !!}</span>
                            <span class="amount">{{ indianMoneyFormat($pricing['selling_price']) }}</span>
                        </h4>
                        <h6 class="mrp">
                            <span class="currency-icon">{!! $pricing['currency_entity'] !!}</span>
                            <span class="amount">{{ indianMoneyFormat($pricing['mrp']) }}</span>
                        </h6>
                        <div class="discount display-6">
                            <span>{{discountCalculate($pricing['selling_price'], $pricing['mrp'])}}</span>
                            <span>off</span>
                        </div>
                    </div>
                </div>
                @endif
            @else

                @php
                    $subscriptionContent = 'd-none';
                @endphp

                @if ($data->statusDetail->show_email_alert == 1)
                    @if (auth()->guard('web')->check())
                        @if (count($data->subscriptionData) > 0)
                            <div class="subscribed-content">
                                <h6 class="small text-success">
                                    <i class="material-icons">check</i>
                                    You have subscribed to this product. We will send you an email once it becomes available.
                                </h6>
                            </div>
                        @else
                            @php
                                $subscriptionContent = 'd-block';
                            @endphp
                        @endif
                    @else
                        @php
                            $subscriptionContent = 'd-block';
                        @endphp
                    @endif

                    <div class="alert-by-email {{$subscriptionContent}}">
                        <form action="{{ route('front.product.subscribe') }}" method="get">
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="email-field">
                                        <input type="email" class="form-control" name="prod_sub_mail" id="prod_sub_mail" placeholder="Enter email address" maxlength="70" value="{{ old('prod_sub_mail') ? old('prod_sub_mail') : (auth()->guard('web')->check() ? auth()->guard('web')->user()->email : '') }}" required>

                                        @error('prod_sub_mail') <p class="text-danger mt-2 mb-0">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <input type="hidden" name="product_id" value="{{ $data->id }}">
                                    <input type="hidden" name="product_status" value="{{ $data->statusDetail->name }}">
                                    <button type="submit" class="btn btn-dark rounded-0 product-mail-subscribe">Subscribe</button>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-md-12">
                                <p class="text-muted mt-2">This product is {{ $data->statusDetail->name }}. Subscribe to get notification about when it becomes available &amp; more</p>
                            </div>
                        </div>
                    </div>
                @endif
            @endif


            @if (count($data->frontHighlightDetails) > 0)
            <div id="highlight">
                <p class="section-title text-muted">Highlights</p>
                <ul>
                    @foreach ($data->frontHighlightDetails as $highlight)
                        <li class="single-highlight">
                            <div class="d-flex">
                                <div class="img">
                                    <img src="{{ asset($highlight->image_medium) }}" alt="">
                                </div>
                                <div class="content">
                                    <p class="title mb-0">{{ $highlight->title }}</p>

                                    @if ($highlight->details)
                                        <p class="text-muted">{{ $highlight->details }}</p>
                                    @endif
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            @endif


            @if ($data->long_description)
            <div id="description">
                <p class="section-title text-muted">Description</p>
                <div class="ck-content">{!! $data->long_description !!}</div>
            </div>
            @endif


            @if (count($data->activeReviewDetails) > 0)
            <div id="rating-details">
                <p class="section-title text-muted">Rating</p>

                @if ($rating)
                    <div class="reviewed">
                        <div class="rating-details">
                            <div class="ratings-container">
                                <div class="rating-count bg-{{bootstrapRatingTypeColor($rating)}}">
                                    <h5 class="digit">{{ $rating }}</h5> 
                                    <div class="icon">
                                        <i class="material-icons md-light">star</i>
                                    </div>
                                </div>
                                <div class="review-count">{{ indianMoneyFormat(count($data->activeReviewDetails)) }} customer {{ (count($data->activeReviewDetails) > 1) ? 'ratings' : 'rating' }}</div>
                            </div>
                        </div>

                        <div class="rating-short-links">
                            @if (count($data->activeReviewDetails) > 3)
                            <span class="badge text-bg-dark rounded-0">
                                <p class="mb-0 text-light">Top 3 reviews</p>
                            </span>
                            @endif
                            <a href="{{ route('front.product.review.index', $data->slug) }}" class="badge text-bg-light rounded-0">
                                <p class="mb-0">View all reviews</p>
                            </a>
                        </div>

                        <div class="top-reviews">
                            @foreach ($data->activeTopReviewDetails as $reviewIndex => $review)
                            <div class="single-review">
                                <div class="quick-section">
                                    <div class="rating">
                                        <div class="rating-count">
                                            <h5 class="digit">{{ $review->rating }}</h5> 
                                            <div class="icon">
                                                <i class="material-icons md-light">star</i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="user">
                                        <p class="text-muted">{{ $review->name }}</p>
                                    </div>
                                    <div class="datetime">
                                        <div class="icon">
                                            <i class="material-icons">history</i>
                                        </div>
                                        <div class="time">
                                            <p class="text-muted">{{ minsAgo($review->created_at) }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="review-section">
                                    <div class="review-title">
                                        <h5>{{ $review->heading }}</h5>
                                    </div>
                                    <p class="review{{$reviewIndex + 1}} height-3 mb-0 review-shows">
                                        {!! nl2br($review->review) !!}
                                    </p>
                                    <a href="javascript: void(0)" onclick="seeMoreText('review{{$reviewIndex + 1}}', 'more-text{{$reviewIndex + 1}}')" class="more-text{{$reviewIndex + 1}}">See more</a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
            @endif


            {{-- <div id="question">
                <p class="section-title text-muted">Question</p>

                <div class="question-details text-center">
                    <div class="questions-container">
                        <div class="review-count">7,890 questions asked</div>
                    </div>
                </div>

                <div class="question-search">
                    <div class="searchbar">
                        <label for="question-label" class="form-label">Looking for something ?</label>
                        <input type="search" id="question-label" class="form-control" aria-describedby="question-help-block">
                        <div id="question-help-block" class="form-text">
                            Looking for something related to this product ? You can search here
                        </div>
                    </div>

                    <div class="question-result">
                        <div class="head">
                            <p class="text-muted">We could not find anything related to "your search text". <a href="">Ask a question</a></p>

                            <p class="text-muted">We found these related to "your search text". Not satisfied with your result ? <a href="">Ask a question</a></p>
                        </div>

                        <div class="detailed">
                            <div class="single-result">
                                <p class="">Lorem ipsum dolor sit amet consectetur adipisicing elit. Eos qui expedita modi omnis accusamus dolores hic sint temporibus quibusdam sit?</p>
                            </div>
                            <div class="single-result">
                                <p class="">Lorem ipsum dolor sit amet consectetur adipisicing elit. Eos qui expedita modi omnis accusamus dolores hic sint temporibus quibusdam sit?</p>
                            </div>
                            <div class="single-result">
                                <p class="">Lorem ipsum dolor sit amet consectetur adipisicing elit. Eos qui expedita modi omnis accusamus dolores hic sint temporibus quibusdam sit?</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="questions-list">
                    <div class="single-question">
                        <div class="quick-section">
                            <div class="user">
                                <p class="text-muted">Rajeev Krishna Thakur</p>
                            </div>
                            <div class="datetime">
                                <div class="icon">
                                    <i class="material-icons">history</i>
                                </div>
                                <div class="time">
                                    <p class="text-muted">5 years ago</p>
                                </div>
                            </div>
                        </div>
                        <div class="review-section">
                            <div class="review-title">
                                <h5>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Aperiam, unde.</h5>
                            </div>
                            <p class="question2 height-3 mb-0">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quasi veniam inventore enim alias earum mollitia sint ipsam ad maiores consequuntur odio, velit, distinctio itaque expedita molestias laborum accusamus nostrum. Suscipit officiis modi voluptatem iste at autem dignissimos dolores, aliquam sit deleniti impedit quaerat quae nam aliquid! Dolorum recusandae quasi nemo at voluptatem sed provident porro assumenda. Commodi facilis, ab error quaerat optio fugiat odio, atque minima aperiam, rem ex eligendi quidem eaque ratione perferendis libero nobis sint ipsum! Dolorum aliquid quo explicabo dolor maxime? Ratione sed fuga, recusandae ipsa itaque dignissimos, dolorum saepe omnis voluptates autem odit nemo vel provident?
                            </p>
                            <a href="javascript: void(0)" onclick="seeMoreTextQuestion('question2', 'q-more-text2')" class="q-more-text2">See more</a>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
</section>

{{-- <section id="similar-products">
    <h5 class="text-muted">Similar products</h5>
    <div class="swiper swiper-similar">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="single-product">
                    <div class="card">
                        <a href="#">
                            <div class="full-container">
                                <div class="image-container">
                                    <div class="image-holder">
                                        <img src="https://torzo.in/uploads/product/5tehgfu780hgfhv/8297nr8728roshjskd (1).jpeg" alt="image">
                                    </div>
                                </div>
                                <div class="description-container">
                                    <div class="product-title">
                                        <h5>Loud &amp; Big Vamavarti (12 cms) Blowing Shankh (White)</h5>
                                    </div>
                                    <div class="pricing">
                                        <h4 class="selling-price">
                                            <span class="currency-icon">₹</span>
                                            <span class="amount">599</span>
                                        </h4>
                                        <h6 class="mrp">
                                            <span class="currency-icon">₹</span>
                                            <span class="amount">2,000</span>
                                        </h6>
                                    </div>
                                    <div class="discount">
                                        <span>70%</span>
                                        <span>off</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="single-product">
                    <div class="card">
                        <a href="#">
                            <div class="full-container">
                                <div class="image-container">
                                    <div class="image-holder">
                                        <img src="https://torzo.in/uploads/product/876hfgjfhdk87uj/98ey5ftiehjdhkgfh%20(1).jpeg" alt="image">
                                    </div>
                                </div>
                                <div class="description-container">
                                    <div class="product-title">
                                        <h5>Shakha Pola (Pack of 2)</h5>
                                    </div>
                                    <div class="rating">
                                        <div class="rating-count">
                                            <h5 class="digit">3.8</h5> 
                                            <div class="icon">
                                                <i class="material-icons md-light">star</i>
                                            </div>
                                        </div>
                                        <div class="review-count">(7,890)</div>
                                    </div>
                                    <div class="pricing">
                                        <h4 class="selling-price">
                                            <span class="currency-icon">₹</span>
                                            <span class="amount">449</span>
                                        </h4>
                                        <h6 class="mrp">
                                            <span class="currency-icon">₹</span>
                                            <span class="amount">1,400</span>
                                        </h6>
                                        <div class="discount">
                                            <span>56%</span>
                                            <span>off</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>
</section> --}}

@if (!empty($recentlyViewedProducts['data']))
<section id="recently viewed">
    <h5 class="text-muted">Recently viewed</h5>
    <div class="swiper swiper-recent">
        <div class="swiper-wrapper">
            @foreach ($recentlyViewedProducts['data'] as $activityLoggedData)
                @if ($activityLoggedData->product)

                    @php
                        $product = $activityLoggedData->product;
                        if (!in_array($product->status, showInFrontendProductStatusID())) continue;
                    @endphp

                    <div class="swiper-slide">
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
                                                @php
                                                    $rating = ratingCalculation(json_decode($product->activeReviewDetails, true));
                                                @endphp

                                                @if ($rating)
                                                    <div class="rating">
                                                        <div class="rating-count bg-{{bootstrapRatingTypeColor($rating)}}">
                                                            <h5 class="digit">{{ $rating }}</h5> 
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
                @endif
            @endforeach
            {{-- <div class="swiper-slide">
                <div class="single-product">
                    <div class="card">
                        <a href="#">
                            <div class="full-container">
                                <div class="image-container">
                                    <div class="image-holder">
                                        <img src="https://torzo.in/uploads/product/5tehgfu780hgfhv/8297nr8728roshjskd (1).jpeg" alt="image">
                                    </div>
                                </div>
                                <div class="description-container">
                                    <div class="product-title">
                                        <h5>Loud &amp; Big Vamavarti (12 cms) Blowing Shankh (White)</h5>
                                    </div>
                                    <div class="rating">
                                        <div class="rating-count">
                                            <h5 class="digit">3</h5> 
                                            <div class="icon">
                                                <i class="material-icons md-light">star</i>
                                            </div>
                                        </div>
                                        <div class="review-count">(7,890)</div>
                                    </div>
                                    <div class="pricing">
                                        <h4 class="selling-price">
                                            <span class="currency-icon">₹</span>
                                            <span class="amount">599</span>
                                        </h4>
                                        <h6 class="mrp">
                                            <span class="currency-icon">₹</span>
                                            <span class="amount">2,000</span>
                                        </h6>
                                    </div>
                                    <div class="discount">
                                        <span>70%</span>
                                        <span>off</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <div class="swiper-slide">
                <div class="single-product">
                    <div class="card">
                        <a href="#">
                            <div class="full-container">
                                <div class="image-container">
                                    <div class="image-holder">
                                        <img src="https://torzo.in/uploads/product/876hfgjfhdk87uj/98ey5ftiehjdhkgfh%20(1).jpeg" alt="image">
                                    </div>
                                </div>
                                <div class="description-container">
                                    <div class="product-title">
                                        <h5>Shakha Pola (Pack of 2)</h5>
                                    </div>
                                    <div class="pricing">
                                        <h4 class="selling-price">
                                            <span class="currency-icon">₹</span>
                                            <span class="amount">449</span>
                                        </h4>
                                        <h6 class="mrp">
                                            <span class="currency-icon">₹</span>
                                            <span class="amount">1,400</span>
                                        </h6>
                                        <div class="discount">
                                            <span>56%</span>
                                            <span>off</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div> --}}
        </div>

        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>
</section>
@endif

<input type="hidden" name="_token" value="{{csrf_token()}}">
@endsection

@section('script')
    <script>
        
    </script>
@endsection