@extends('front.layout.app')

@section('page-title', $data->seo->page_title)
@section('meta-title', $data->seo->meta_title)
@section('meta-description', $data->seo->meta_desc)
@section('meta-keywords', $data->seo->meta_keyword)

@section('content')
@if (count($data->banners) > 0)
<div id="banner">
    <div class="swiper swiper-banner">
        <div class="swiper-wrapper">
            @foreach ($data->banners as $banner)
                <div class="swiper-slide">
                    <a href="{{ $banner->web_link }}">
                        {{-- <img src="https://placehold.in/1015x250.webp/dark" alt=""> --}}
                        <img src="{{ asset($banner->desktop_image_large) }}" alt="banner" class="desktop-banner">
                        <img src="{{ asset($banner->mobile_image_large) }}" alt="banner" class="mobile-banner">
                    </a>
                </div>
            @endforeach
        </div>

        <div class="swiper-pagination"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>
</div>
@endif


@if (count($data->collections) > 0)
<section id="content">
    <div class="contents-container">
        @foreach ($data->collections as $collection)
        <div class="single-content">
            <div class="card">
                <a href="{{ route('front.collection.detail', $collection->slug) }}">
                    <img class="card-img-top" src="{{ asset($collection->icon_medium) }}" alt="{{$collection->slug}}">
                    <div class="card-body">
                        <p class="card-text">{{$collection->title}}</p>
                    </div>
                </a>
            </div>
        </div>
        @endforeach

        <div class="single-content">
            <div class="card">
                <a href="{{ route('front.collection.index') }}">
                    <img class="card-img-top" src="{{ asset('uploads/static-svgs/all-collection.png') }}" alt="all-collections">
                    <div class="card-body">
                        <p class="card-text">All collections</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>
@endif


@if (count($data->featuredProducts) > 0)
<section id="deals">
    <p class="text-muted">BEST DEALS</p>
    <div class="swiper swiper-deals">
        <div class="swiper-wrapper">
            @foreach ($data->featuredProducts as $featuredProduct)
                @if ($featuredProduct->productDetail)

                    @php
                        $product = $featuredProduct->productDetail;
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


@endsection