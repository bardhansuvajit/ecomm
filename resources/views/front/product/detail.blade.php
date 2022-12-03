@extends('front.layout.app')

@section('page-title', 'Product detail')

@section('style')
    <link rel="stylesheet" href="{{asset('./packages/lightGallery-master/css/lightgallery.css')}}">
    <link rel="stylesheet" href="{{asset('./packages/lightGallery-master/css/lg-zoom.css')}}">
    <link rel="stylesheet" href="{{asset('./packages/lightGallery-master/css/lg-thumbnail.css')}}">
@endsection

@section('section')
<section class="product-detail mb-3">
    <div class="row">
        <div class="col-12 col-md-12">
            {{-- <div class="fixed-image-holder" style="height: 200px">
                <img src="{{ asset($data->imageDetails[0]->img_50) }}" alt="">
            </div> --}}
            <div class="gallery-container" id="product-detail-gallery">
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
                {{-- <a data-lg-size="1600-1067" data-pinterest-text="Pin it3" data-tweet-text="lightGallery slide  4" class="gallery-item" data-src="https://images.unsplash.com/photo-1505820013142-f86a3439c5b2?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&auto=format&fit=crop&w=1600&q=80" data-sub-html="<h4>Photo by - <a href='https://unsplash.com/@flovayn' >Florian van Duyn</a></h4><p>Location - <a href='Bled, Slovenia'>Bled, Slovenia</a> </p>">
                  <img class="img-responsive" src="https://images.unsplash.com/photo-1505820013142-f86a3439c5b2?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&auto=format&fit=crop&w=240&q=80" />
                </a>
                <a data-lg-size="1600-1126" data-pinterest-text="Pin it3" data-tweet-text="lightGallery slide  4" class="gallery-item" data-src="https://images.unsplash.com/photo-1477322524744-0eece9e79640?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1600&q=80" data-sub-html="<h4>Photo by - <a href='https://unsplash.com/@juanster' >Juan Davila</a></h4><p>Location - <a href='Bled, Slovenia'>Bled, Slovenia</a> Wooded lake island </p>">
                  <img class="img-responsive" src="https://images.unsplash.com/photo-1477322524744-0eece9e79640?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&auto=format&fit=crop&w=240&q=80" />
                </a> --}}
            </div>
        </div>
        <div class="col-12 text-end">
            <p class="small text-muted mb-0">Click on image to zoom</p>
        </div>
    </div>

    <hr class="d-none d-md-block">

    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-12 col-md-5">
                    <div class="highlight-content">
                        <div class="product-title">
                            <h5 class="fs-5">{{$data->title}}</h5>
                        </div>

                        <div class="ratings">
                            <div class="rating-details">
                                <p>4.5</p>
                            </div>
                            <div class="review-count">
                                <p class="text-muted">(22,988)</p>
                            </div>
                        </div>

                        <div class="pricing">
                            @if(!empty($data->offer_price))
                                {{-- sell price --}}
                                <h5 class="sell-price display-6">&#8377; {{number_format($data->offer_price)}}</h5>
                                {{-- mrp --}}
                                <h5 class="max-retail-price text-muted">&#8377; {{ number_format($data->price) }}</h5>
                                <h5 class="discount display-6">{{ discountCalculate($data->offer_price, $data->price) }} OFF</h5>
                            @else
                                {{-- sell price --}}
                                <h5 class="sell-price display-6">&#8377; {{number_format($data->price)}}</h5>
                            @endif
                        </div>

                        <div class="purchase d-none d-md-block mt-3">
                            <div class="row">
                                <div class="col-6">
                                    <form action="{{ route('wishlist.toggle') }}" method="post" class="wishlistForm">@csrf
                                        <button type="submit" class="btn btn-secondary add-cart">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="{{ ($wishlistToggle == "active") ? '#FF5722' :'none' }}" stroke="{{ ($wishlistToggle == "active") ? '#FF5722' :'currentColor' }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                                            Wishlist
                                        </button>
                                    </form>
                                </div>
                                <div class="col-6 add-to-cart-container">
                                    @if (empty($cartRedirectTo))
                                        <form action="{{ route('cart.add') }}" method="post" class="addToCartForm">
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
                </div>

                <div class="col-12 col-md-7 mt-3 mt-md-0">
                    <div class="product-details">
                        <div class="row">
                            <div class="col-12 d-flex">
                                <p class="text-muted">Description</p>
                                <div class="line"></div>
                            </div>
                            <div class="col-12">
                                <div class="hightlight-content">
                                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nihil magnam molestiae, ratione ipsa repellat eveniet enim aut nam temporibus asperiores tempora obcaecati velit quod laudantium commodi provident ipsam debitis inventore praesentium? Quaerat expedita omnis totam, error sequi voluptatum officia quia quasi consectetur atque eos saepe odit qui, repellat ratione fugit.</p>
                                    <ul>
                                        <li>Lorem ipsum dolor sit amet.</li>
                                        <li>Lorem ipsum dolor sit.</li>
                                        <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Odit, eaque?</li>
                                        <li>Lorem, ipsum dolor sit amet consectetur adipisicing.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 d-flex">
                                <p class="text-muted">Review</p>
                                <div class="line"></div>
                            </div>
        
                            <div class="col-12">
                                <div class="rating-content text-center text-mb-left">
                                    <h5>
                                        <span class="badge bg-primary">4.5</span>
                                        <span class="text-muted">/5</span>
                                    </h5>
                                    <p class="small text-muted">2,889 Reviews</p>
                                    <a href="{{route('front.product.detail.review.create', $data->slug)}}" class="btn btn-sm btn-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-down"><path d="M10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3zm7-13h2.67A2.31 2.31 0 0 1 22 4v7a2.31 2.31 0 0 1-2.33 2H17"></path></svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-up"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path></svg>
                                        Review
                                    </a>
                                    <a href="{{route('front.product.detail.review.list', $data->slug)}}" class="btn btn-sm btn-secondary">
                                        See all reviews
                                    </a>
                                </div>
                            </div>
        
                            <div class="col-12 mt-3">
                                <div class="top-3-reviwes">
                                    <div class="card-group">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">Suvajit Bardhan</h5>
                                                <p class="card-text review-title">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                                <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">John Smith</h5>
                                                <p class="card-text review-title">This card has supporting text below as a natural lead-in to additional content.</p>
                                                <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">Rakesh Juunjhunwalia</h5>
                                                <p class="card-text review-title">This is a wider card with supporting text below as a natural lead-in to additional content. This card has even longer content than the first to show that equal height action.</p>
                                                <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                                            </div>
                                        </div>
                                        <div class="card all-reviews-card d-block d-md-none">
                                            <div class="card-body text-center">
                                                <a href="{{route('front.product.detail.review.list', $data->slug)}}">
                                                    <h5 class="card-title">View all reviews</h5>
                                                    <p class="card-text">View all reviews by our customers and filter them as you need</p>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- related products --}}
    <section class="highlighted-products mb-3 mt-3">
        <div class="row">
            <div class="col-12 d-flex">
                <p class="text-muted ws-nowrap">Related Products</p>
                <div class="line"></div>
            </div>

            @php
                $products = \App\Models\Product::orderBy('id', 'desc')->with('imageDetails')->get();
            @endphp

            @foreach ($products as $product)
            <div class="col-6 col-md-2">
                <a href="{{ route('front.product.detail', $product->slug) }}">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="fixed-image-holder" style="height: 130px">
                                <img src="{{ asset($product->imageDetails[0]->img_50) }}" alt="">
                            </div>
                            <p class="card-text mb-2 product-title">{{$product->title}}</p>
                            <div class="price-section">
                                @if(!empty($product->offer_price))
                                    <p class="sell-price">&#8377; {{ number_format($product->offer_price) }}</p>
                                    <p class="max-retail-price">&#8377; {{ number_format($product->price) }}</p>
                                    <p class="discount">{{ discountCalculate($product->offer_price, $product->price) }}</p>
                                @else
                                    <p class="sell-price">&#8377; {{ number_format($product->price) }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </section>
</section>

<input type="hidden" name="product_id" value="{{$data->id}}">
<input type="hidden" name="_token" value="{{csrf_token()}}">
<input type="hidden" name="user_id" value="{{auth()->guard('web')->check() ? auth()->guard('web')->user()->id : 0}}">

{{-- cart/ buy now hightlight - only mobile --}}
<nav class="navbar fixed-bottom redirect_buttons_mobile">
    <div class="row gx-3 mx-0">
        <div class="col-6">
            <a href="javascript: void(0)" class="btn btn-secondary text-start w-100" id="mobile_checkout_info">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                Buy now
            </a>
        </div>
        <div class="col-6">
            <form action="{{ route('cart.add') }}" method="post">@csrf
                <input type="hidden" name="product_id" value="{{$data->id}}">
                <button type="submit" class="btn btn-primary text-end w-100">
                    Add to cart
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                </button>
            </form>
        </div>
    </div>
</nav>
@endsection

@section('script')
    <script src="{{asset('./packages/lightGallery-master/lightgallery.umd.js')}}"></script>
    <script src="{{asset('./packages/lightGallery-master/plugins/zoom/lg-zoom.umd.js')}}"></script>
    <script src="{{asset('./packages/lightGallery-master/plugins/thumbnail/lg-thumbnail.umd.js')}}"></script>

    <script>
        lightGallery(document.getElementById('product-detail-gallery'), {
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