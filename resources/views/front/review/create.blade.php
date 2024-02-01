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
                        <li class="breadcrumb-item"><a href="{{ route('front.product.review.index', $product->slug) }}">Reviews</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Write Review</li>
                    </ol>
                </nav>
            </div>

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
                </div>

                <div class="col-md-10">
                    @if ($check['status'] == 'failure')
                        <div id="write-review-container">
                            <form action="{{ route('front.product.review.upload') }}" method="post">@csrf
                                <div class="form-group mb-3">
                                    <label for="rating"><p class="text-muted mb-2">Overall rating</p></label>

                                    <div class="star-rating star-5">
                                        <input type="radio" name="rating" value="1" {{ (old('rating') == 1) ? 'checked' : '' }}><i></i>
                                        <input type="radio" name="rating" value="2" {{ (old('rating') == 2) ? 'checked' : '' }}><i></i>
                                        <input type="radio" name="rating" value="3" {{ (old('rating') == 3) ? 'checked' : '' }}><i></i>
                                        <input type="radio" name="rating" value="4" {{ (old('rating') == 4) ? 'checked' : '' }}><i></i>
                                        <input type="radio" name="rating" value="5" {{ (old('rating') == 5) ? 'checked' : '' }}><i></i>
                                    </div>
                                    @error('rating') <p class="text-danger">{{ $message }}</p> @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="heading"><p class="text-muted mb-2">Heading</p></label>
                                    <textarea name="heading" id="heading" class="form-control" placeholder="Enter heading" rows="1">{{ old('heading') }}</textarea>
                                    @error('heading') <p class="text-danger">{{ $message }}</p> @enderror
                                </div>

                                <div class="form-group mb-4">
                                    <label for="heading"><p class="text-muted mb-2">Detailed review</p></label>
                                    <textarea name="review" id="review" class="form-control" placeholder="Enter review" rows="4">{{ old('review') }}</textarea>
                                    @error('review') <p class="text-danger">{{ $message }}</p> @enderror
                                </div>

                                <div class="form-group">
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button type="submit" class="btn btn-dark btn-sm rounded-0">Submit</button>
                                    <p class="text-muted mt-2">After submission your review will be verified. Once verified it will be approved.</p>
                                </div>
                            </form>
                        </div>
                    @else
                        <div id="already-reviewed">
                            <div class="row justify-content-center">
                                <div class="col-md-4 text-center">
                                    <div class="alert bg-success text-light">
                                        <h6 class="mb-2">You already reviewed !</h6>

                                        <p class="mb-2">You have already reviewed this product. </p>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div id="rating-details">
                                        <div class="reviewed">
                                            <div class="top-reviews">
                                                <div class="single-review">
                                                    <div class="quick-section">
                                                        <div class="rating">
                                                            <div class="rating-count">
                                                                <h5 class="digit">{{ $check['data']->rating }}</h5> 
                                                                <div class="icon">
                                                                    <i class="material-icons md-light">star</i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="user">
                                                            <p class="text-muted">{{ $check['data']->name }}</p>
                                                        </div>
                                                        <div class="datetime">
                                                            <div class="icon">
                                                                <i class="material-icons">history</i>
                                                            </div>
                                                            <div class="time">
                                                                <p class="text-muted">{{ minsAgo($check['data']->created_at) }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="review-section">
                                                        <div class="review-title">
                                                            <h5>{{ $check['data']->heading }}</h5>
                                                        </div>
                                                        <p class="review1 height-3 mb-0 review-shows">
                                                            {!! nl2br($check['data']->review) !!}
                                                        </p>
                                                        <a href="javascript: void(0)" onclick="seeMoreText('review1', 'more-text1')" class="more-text1">See more</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
