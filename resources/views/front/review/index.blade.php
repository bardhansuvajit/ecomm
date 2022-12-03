@extends('front.layout.app')

@section('page-title', 'Reviews')

@section('style')
    <link rel="stylesheet" href="{{asset('./packages/lightGallery-master/css/lightgallery.css')}}">
    <link rel="stylesheet" href="{{asset('./packages/lightGallery-master/css/lg-zoom.css')}}">
    <link rel="stylesheet" href="{{asset('./packages/lightGallery-master/css/lg-thumbnail.css')}}">
@endsection

@section('section')
<section class="review-list mb-3">
    <div class="row">
        <div class="col-12">
            <p class="display-6">Reviews</p>
        </div>
        <div class="col-12">
            <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('front.home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('front.product.detail', $product->slug) }}">{{$product->title}}</a></li>
                    <li class="breadcrumb-item active fw-600" aria-current="page">Reviews</li>
                </ol>
            </nav>
        </div>

        <div class="col-12">
            <div class="row">
                <div class="col-md-8">
                    @if(count($reviews) > 0)
                        <div class="review-filters mt-3">
                            <form action="" class="" id="reviewFilterForm">
                                <div class="row justify-content-end">
                                    <div class="col-auto">
                                        <label for="sort_by" class="small text-muted fw-600">Sort by</label>
                                        <select name="sort_by" id="sort_by" class="form-select form-select-sm" form="reviewFilterForm">
                                            <option value="top-reviews" {{ (request()->input('sort_by') == "top-reviews") ? 'selected' : '' }}>Top reviews</option>
                                            <option value="recent-reviews" {{ (request()->input('sort_by') == "recent-reviews") ? 'selected' : '' }}>Recent reviews</option>
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <label for="show" class="small text-muted fw-600">Show</label>
                                        <select name="show" id="show" class="form-select form-select-sm" form="reviewFilterForm">
                                            <option value="all-reviews" {{ (request()->input('show') == "all-reviews") ? 'selected' : '' }}>All reviews</option>
                                            <option value="5-stars-only" {{ (request()->input('show') == "5-stars-only") ? 'selected' : '' }}>5 star only</option>
                                            <option value="4-stars-only" {{ (request()->input('show') == "4-stars-only") ? 'selected' : '' }}>4 star only</option>
                                            <option value="3-stars-only" {{ (request()->input('show') == "3-stars-only") ? 'selected' : '' }}>3 star only</option>
                                            <option value="2-stars-only" {{ (request()->input('show') == "2-stars-only") ? 'selected' : '' }}>2 star only</option>
                                            <option value="1-star-only" {{ (request()->input('show') == "1-star-only") ? 'selected' : '' }}>1 star only</option>
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <label for="keyword" class="small text-muted fw-600">Search</label>
                                        <input type="text" class="form-control form-control-sm" id="keyword" placeholder="What are you looking for" name="keyword" value="{{request()->input('keyword')}}" autocomplete="none" maxlength="30">
                                    </div>
                                    <div class="col-auto">
                                        <input type="hidden" name="filter" value="on">
                                        <button class="btn btn-sm btn-secondary mt-4">Filter</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div id="reviews-here" class="mt-4">
                            @foreach ($reviews as $review)
                            <div class="single-review mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-2 text-center">
                                                <h5 class="display-6 mb-1">{{ ratingShow($review->rating) }}</h5>

                                                {!! ratingStarShow($review->rating) !!}
                                            </div>
                                            <div class="col-10">
                                                <h5 class="review-title mb-3">{{ $review->title }}</h5>
                                                <p class="small text-muted shorten-text">{{ $review->description }}</p>

                                                {{-- review files --}}
                                                @if(count($review->fileDetail) > 0)
                                                    <div class="row mb-3">
                                                        <div class="col-12">
                                                            <div class="gallery-container review-files-gallery">
                                                                @foreach ($review->fileDetail as $reviewFile)
                                                                    {{-- <img src="{{ asset($reviewFile->file) }}" alt="" height="50" class="me-3"> --}}
                                                                    <a data-lg-size="1600-1067" class="gallery-item" data-src="{{ asset($reviewFile->file_medium) }}">
                                                                        <img class="img-responsive" src="{{ asset($reviewFile->file_smaller) }}" alt="" />
                                                                    </a>
                                                                @endforeach
                                                            </div>

                                                            {{-- <div class="gallery-container review-files-gallery">
                                                                <a data-lg-size="1600-1067" class="gallery-item" data-src="https://images.unsplash.com/photo-1609342122563-a43ac8917a3a?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&auto=format&fit=crop&w=1600&q=80">
                                                                    <img class="img-responsive" src="https://images.unsplash.com/photo-1609342122563-a43ac8917a3a?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&auto=format&fit=crop&w=240&q=80" />
                                                                </a>
                                                                <a data-lg-size="1600-2400" data-pinterest-text="Pin it2" data-tweet-text="lightGallery slide  2" class="gallery-item" data-src="https://images.unsplash.com/photo-1608481337062-4093bf3ed404?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&auto=format&fit=crop&w=1600&q=80">
                                                                    <img class="img-responsive" src="https://images.unsplash.com/photo-1608481337062-4093bf3ed404?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&auto=format&fit=crop&w=240&q=80" />
                                                                </a>
                                                                <a data-lg-size="1600-2400" data-pinterest-text="Pin it3" data-tweet-text="lightGallery slide  4" class="gallery-item" data-src="https://images.unsplash.com/photo-1605973029521-8154da591bd7?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&auto=format&fit=crop&w=1600&q=80">
                                                                    <img class="img-responsive" src="https://images.unsplash.com/photo-1605973029521-8154da591bd7?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&auto=format&fit=crop&w=240&q=80" />
                                                                </a>
                                                                <a data-lg-size="1600-2398" data-pinterest-text="Pin it3" data-tweet-text="lightGallery slide  4" class="gallery-item" data-src="https://images.unsplash.com/photo-1526281216101-e55f00f0db7a?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&auto=format&fit=crop&w=1600&q=80" data-sub-html="<h4>Photo by - <a href='https://unsplash.com/@yusufevli' >Yusuf Evli </a></h4><p> Foggy Road</p>">
                                                                    <img class="img-responsive" src="https://images.unsplash.com/photo-1526281216101-e55f00f0db7a?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&auto=format&fit=crop&w=240&q=80" />
                                                                </a>
                                                                <a data-lg-size="1600-1067" data-pinterest-text="Pin it3" data-tweet-text="lightGallery slide 4" class="gallery-item" data-src="https://images.unsplash.com/photo-1418065460487-3e41a6c84dc5?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1600&q=80">
                                                                    <img class="img-responsive" src="https://images.unsplash.com/photo-1418065460487-3e41a6c84dc5?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=240&q=80" />
                                                                </a>
                                                            </div> --}}
                                                        </div>
                                                    </div>
                                                @endif

                                                <div class="d-flex justify-content-between">
                                                    @if($review->userDetail)
                                                        <p class="small text-dark">Review by {{$review->userDetail->first_name}} {{$review->userDetail->last_name}}</p>
                                                    @endif
                                                    <p class="small text-dark">{{ $review->created_at->diffForHumans() }}</p>
                                                </div>

                                                <div class="review-buttons">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="left-part">
                                                            <div class="btn-group">
                                                                @auth
                                                                    @php
                                                                        $loggedinUserLikeCheck = $review->likeDetailUserCheck->count();
                                                                        $loggedinUserDislikeCheck = $review->dislikeDetailUserCheck->count();

                                                                        if ($loggedinUserLikeCheck > 0) {
                                                                            $fill1 = "#000"; $stroke1 = "#000";
                                                                        } else {
                                                                            $fill1 = "none"; $stroke1 = "currentColor";
                                                                        }

                                                                        if ($loggedinUserDislikeCheck > 0) {
                                                                            $fill2 = "#000"; $stroke2 = "#000";
                                                                        } else {
                                                                            $fill2 = "none"; $stroke2 = "currentColor";
                                                                        }
                                                                    @endphp
                                                                @else
                                                                    @php
                                                                        $fill1 = "none"; $stroke1 = "currentColor";
                                                                        $fill2 = "none"; $stroke2 = "currentColor";
                                                                    @endphp
                                                                @endauth

                                                                <a href="javascript: void(0)" class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="Is this review helpful ?" onclick="reviewInteractFunc({{$review->id}}, 1)">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="{{$fill1}}" stroke="{{$stroke1}}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-up like_{{$review->id}}"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path></svg>

                                                                    @if (count($review->likeDetail) > 0)
                                                                        <span class="fw-600">{{ count($review->likeDetail) }}</span>
                                                                    @endif
                                                                </a>
                                                                <a href="javascript: void(0)" class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="Is this review not helpful ?" onclick="reviewInteractFunc({{$review->id}}, 0)">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="{{$fill2}}" stroke="{{$stroke2}}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-down dislike_{{$review->id}}"><path d="M10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3zm7-13h2.67A2.31 2.31 0 0 1 22 4v7a2.31 2.31 0 0 1-2.33 2H17"></path></svg>

                                                                    @if (count($review->dislikeDetail) > 0)
                                                                        <span class="fw-600">{{ count($review->dislikeDetail) }}</span>
                                                                    @endif
                                                                </a>
                                                            </div>
                                                        </div>

                                                        <div class="right-part">
                                                            <a href="javascript: void(0)" class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="Flag as inappropriate">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-flag"><path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"></path><line x1="4" y1="22" x2="4" y2="15"></line></svg>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="laravel-pagination">
                            {{$reviews->appends($_GET)->links()}}
                        </div>
                    @else
                        <section class="cart-empty">
                            <div class="row">
                                <div class="col-12 mb-4">
                                    <div class="card mb-4 border-0 not-found">
                                        <div class="card-body text-center py-4">
                                            <img src="{{asset('images/static-svgs/undraw_add_to_cart_re_wrdo.svg')}}" alt="" height="100">
                    
                                            <h5 class="heading">No reviews found</h5>
                    
                                            <p class="text-muted">Place orders now and get exciting offers.</p>
                    
                                            @if (empty($cartRedirectTo))
                                                <form action="{{ route('cart.add') }}" method="post" class="addToCartForm">
                                                    <input type="hidden" name="product_id" value="{{$product->id}}">
                                                    <button type="submit" class="btn btn-primary add-cart">
                                                        Add to cart
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                                                    </button>
                                                </form>
                                            @else
                                                <a href="{{ route('front.cart.index') }}" class="btn btn-primary add-cart">
                                                    Go to Cart
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    @endif
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="overall-review">
                                <div class="text-center">
                                    <h5 class="display-6 mb-1">4.1</h5>
        
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="#000" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="#000" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="#000" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="#000" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                </div>
                            </div>

                            <div class="product-detail mt-3">
                                <div class="row">
                                    <div class="col-3">
                                        <a href="{{ route('front.product.detail', $product->slug) }}" target="_blank">
                                            <div class="fixed-image-holder" style="height: 65px">
                                                <img src="{{ asset($product->imageDetails[0]->img_50) }}" alt="">
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-9">
                                        <a href="{{ route('front.product.detail', $product->slug) }}" target="_blank">
                                            <p class="card-text mb-2 product-title">{{$product->title}}</p>
                                        </a>

                                        <div class="d-flex">
                                            @if(!empty($product->offer_price))
                                                {{-- sell price --}}
                                                <p class="sell-price mb-0">&#8377;{{number_format($product->offer_price)}}</p>
                                                {{-- mrp --}}
                                                <p class="max-retail-price text-muted mb-0 mx-3">&#8377;{{ number_format($product->price) }}</p>
                                                <p class="discount mb-0">{{ discountCalculate($product->offer_price, $product->price) }} OFF</p>
                                            @else
                                                {{-- sell price --}}
                                                <p class="sell-price mb-0">&#8377;{{number_format($product->price)}}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <form action="{{ route('wishlist.toggle') }}" method="post" class="wishlistForm">@csrf
                                            <button type="submit" class="btn btn-secondary add-cart w-100">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="{{ ($wishlistToggle == "active") ? '#FF5722' :'none' }}" stroke="{{ ($wishlistToggle == "active") ? '#FF5722' :'currentColor' }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                                                Wishlist
                                            </button>
                                        </form>
                                    </div>
                                    <div class="col-6 add-to-cart-container">
                                        @if (empty($cartRedirectTo))
                                            <form action="{{ route('cart.add') }}" method="post" class="addToCartForm">
                                                <input type="hidden" name="product_id" value="{{$product->id}}">
                                                <button type="submit" class="btn btn-primary add-cart w-100">
                                                    Add to cart
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ route('front.cart.index') }}" class="btn btn-primary add-cart w-100">
                                                Go to Cart
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                                            </a>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<input type="hidden" name="_token" value="{{csrf_token()}}">
<input type="hidden" name="user_id" value="{{auth()->guard('web')->check() ? auth()->guard('web')->user()->id : 0}}">
@endsection

@section('script')
    <script src="{{asset('./packages/lightGallery-master/lightgallery.umd.js')}}"></script>
    <script src="{{asset('./packages/lightGallery-master/plugins/zoom/lg-zoom.umd.js')}}"></script>
    <script src="{{asset('./packages/lightGallery-master/plugins/thumbnail/lg-thumbnail.umd.js')}}"></script>

    <script>
        modifyDomElements('shorten-text', '66px');

        // review interaction
        function reviewInteractFunc(id, type) {
            const userId = $('input[name="user_id"]').val();

            if (userId != 0) {
                $.ajax({
                    url : "{{route('review.toggle')}}",
                    method : 'POST',
                    data : {
                        _token: $('input[name="_token"]').val(),
                        id: id,
                        user_id: userId,
                        type: type
                    },
                    beforeSend: function() {
                        toastFire('info', 'Please wait...');
                    },
                    success: function(result) {
                        if (result.status == 400) {
                            toastFire('error', result.message);
                        } else {
                            // if liked
                            if (type == 1) {
                                if (result.type == "add") {
                                    $('.like_'+id).attr('fill', '#000').attr('stroke', '#000');
                                    $('.dislike_'+id).attr('fill', 'none').attr('stroke', 'currentColor');
                                } else {
                                    $('.like_'+id).attr('fill', 'none').attr('stroke', 'currentColor');
                                }
                            } else {
                                if (result.type == "add") {
                                    $('.dislike_'+id).attr('fill', '#000').attr('stroke', '#000');
                                    $('.like_'+id).attr('fill', 'none').attr('stroke', 'currentColor');
                                } else {
                                    $('.dislike_'+id).attr('fill', 'none').attr('stroke', 'currentColor');
                                }
                            }

                            toastFire('success', result.message);
                        }
                    }
                });
            } else {
                toastFire('warning', '<a href="/user/login">Login</a> to continue');
            }
        }

        lightGallery(document.querySelector('.review-files-gallery'), {
            plugins: [lgZoom, lgThumbnail],
            speed: 500,
            showCloseIcon : true,
            pager: true,
            download: false,
            mobileSettings: {
                controls: false,
                showCloseIcon: true,
                download: false,
                rotate: false,
                showZoomInOutIcons: false
            }
        });
    </script>
@endsection