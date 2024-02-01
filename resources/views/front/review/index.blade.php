@extends('front.layout.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <section id="content-lists">
            <div id="breadcrumb">
                <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('front.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('front.product.detail', $product->slug) }}">{{ $product->title }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Reviews</li>
                    </ol>
                </nav>
            </div>

            @php
                $rating = ratingCalculation(json_decode($product->activeReviewDetails, true));
            @endphp

            <div class="row mt-5">
                <div class="col-md-2">
                    <div id="product">
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
                </div>

                <div class="col-md-10">
                    <div id="breakdown">
                        <div class="heading">
                            <h6 class="text-muted">Rating Breakdown</h6>
                        </div>

                        <div class="rating-container">
                            <div class="original-rating">
                                <div class="badge bg-{{bootstrapRatingTypeColor($rating)}}">
                                    {{ $rating }}
                                    <i class="material-icons">star</i>
                                </div>
                            </div>
                            <div class="divider">
                                /
                            </div>
                            <div class="out-of">
                                5
                            </div>
                        </div>

                        <div class="quick-ratings">
                            <h6 class="text-muted">8,11,895 Ratings & 8,11,895 reviews</h6>
                        </div>
                    </div>

                    <div id="create-review">
                        <a href="{{ route('front.product.review.create', $product->slug) }}" class="btn btn-sm btn-dark rounded-0">
                            Review Product
                            <i class="material-icons">thumbs_up_down</i>
                        </a>
                    </div>

                    <hr>

                    @if (count($activeReviews['data']) > 0)
                    <div id="rating-details">
                        @if ($rating)
                            <div class="reviewed">
                                <div class="top-reviews">
                                    @foreach ($activeReviews['data'] as $reviewIndex => $review)
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

                                <div class="pagination justify-content-center mt-5">
                                    {{ $activeReviews['data']->links() }}
                                </div>
                            </div>
                        @endif
                    </div>
                    @endif


                </div>
            </div>
        </section>
    </div>
</div>
@endsection