@extends('front.layout.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-9">
        <section id="orders">
            <div class="row mb-5">
                <div class="col-12">
                    <div class="page-head">
                        <div class="redirect me-3">
                            {{-- <a href="javascript: void(0)" onclick="history.back(-1)"> --}}
                            <a href="{{ route('front.user.account') }}">
                                <i class="material-icons">keyboard_arrow_left</i>
                            </a>
                        </div>
                        <div class="text">
                            <h5>My wishlist</h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                @if (count($resp['data']) > 0)
                    @foreach ($resp['data'] as $wishlishProduct)

                    @php
                        $product = $wishlishProduct->productDetails;
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
                                        <button class="wishlist-btn" onclick="wishlistToggle({{$data->id}})">
                                            <i class="material-icons">favorite_border</i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <div class="col-12">
                        <div id="pagination" class="mt-4">
                            {{ $resp['data']->links() }}
                        </div>
                    </div>
                @else
                    <div class="col-12">
                        <div class="empty text-center">
                            <div class="image">
                                <img src="{{ asset('uploads/static-svgs/undraw_product_tour_re_8bai.svg') }}" alt="loading-cart" class="w-100">
                            </div>
                            <h6>No products found...</h6>
                            <p class="small text-muted">You can check our collections &amp; wishlist products</p>
                            <a href="{{ route('front.collection.index') }}" class="btn btn-sm rounded-0 btn-dark">Go to collections</a>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </div>
</div>
@endsection