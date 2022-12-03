@extends('front.layout.app')

@section('page-title', 'Home')

@section('section')
{{-- banner --}}
<section class="homepage-banner mb-2">
    <div class="row">
        <div class="col-md-6 px-0">
            <div class="swiper homepage-banner">
                <div class="swiper-wrapper">
                    {{-- <div class="swiper-slide">
                        <img src="{{ asset('uploads/banner/9c1beea4f5736a07.jpg') }}" alt="">
                    </div> --}}
                    <div class="swiper-slide">
                        <img src="{{ asset('uploads/banner/58a31755d7bdc59d.jpg') }}" alt="">
                    </div>
                    <div class="swiper-slide">
                        <img src="{{ asset('uploads/banner/5881b218dcd5580f.jpg') }}" alt="">
                    </div>
                    <div class="swiper-slide">
                        <img src="{{ asset('uploads/banner/296014868c5a912c.jpg') }}" alt="">
                    </div>
                    <div class="swiper-slide">
                        <img src="{{ asset('uploads/banner/a56b53db68308770.jpg') }}" alt="">
                    </div>
                    <div class="swiper-slide">
                        <img src="{{ asset('uploads/banner/af9f75f65cef97f1.jpg') }}" alt="">
                    </div>
                </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        </div>

        <div class="col-md-6 px-0 d-none d-md-block">
            <div class="card card-body text-center" style="height: 100%">
                <h3>Who are we?</h3>
                <p class="small">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Non corporis laudantium soluta iste expedita voluptatum dicta. Reprehenderit modi beatae temporibus, ullam tempora ipsam facere labore perferendis esse quisquam illum illo quas? Maiores excepturi, cum, voluptate ipsum asperiores quos maxime, deleniti iusto repudiandae fugiat autem ad doloribus error voluptatem laudantium ab esse voluptates facilis tempora quam aut.</p>

                @auth
                    <a href="{{ route('front.home') }}" class="btn btn-primary">Keep shopping</a>
                @else
                    <a href="#loginModal" class="btn btn-primary" data-bs-toggle="modal">Become Partner</a>
                @endauth

                <p class="small mt-3 mb-0">Become Partner today & open many opportunities</p>
            </div>
        </div>
    </div>
</section>

{{-- categories --}}
<section class="all-categories mb-2">
    <div class="row">
        <div class="col-12">
            <p class="text-muted">Category</p>
        </div>
        <div class="col-12">
            <ul class="categories">
                <li class="single-category">
                    <a href="">
                        <img src="{{ asset('uploads/category/cat (1).jpeg') }}" alt="">
                        <p class="small text-muted">Lorem.</p>
                    </a>
                </li>
                <li class="single-category">
                    <a href="">
                        <img src="{{ asset('uploads/category/cat (2).jpeg') }}" alt="">
                        <p class="small text-muted">Lorem ipsum</p>
                    </a>
                </li>
                <li class="single-category">
                    <a href="">
                        <img src="{{ asset('uploads/category/cat (3).jpeg') }}" alt="">
                        <p class="small text-muted">Lorem ipsum dolor</p>
                    </a>
                </li>
                <li class="single-category">
                    <a href="">
                        <img src="{{ asset('uploads/category/cat (4).jpeg') }}" alt="">
                        <p class="small text-muted">Lorem.</p>
                    </a>
                </li>
                <li class="single-category">
                    <a href="">
                        <img src="{{ asset('uploads/category/cat (5).jpeg') }}" alt="">
                        <p class="small text-muted">Lorem.</p>
                    </a>
                </li>
                <li class="single-category">
                    <a href="">
                        <img src="{{ asset('uploads/category/cat (6).jpeg') }}" alt="">
                        <p class="small text-muted">Lorem.</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</section>

{{-- highlighted products --}}
<section class="highlighted-products mb-3">
    <div class="row">
        <div class="col-12">
            <p class="text-muted">Highlighted Products</p>
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

<section class="content mb-3">
    <hr>
    <div class="row">
        <div class="col-12">
            <h3>What is Lorem Ipsum?</h3>

            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>

            <h3>Why do we use it?</h3>

            <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>

            <h3> Where does it come from?</h3>

            <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p>

            <ul>
                <li><p class="mb-0">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Pariatur, tenetur!</p></li>
                <li><p class="mb-0">Lorem ipsum dolor, sit amet consectetur adipisicing elit.</p></li>
                <li><p class="mb-0">Lorem ipsum dolor, sit amet consectetur adipisicing elit.</p></li>
                <li><p class="mb-0">Lorem ipsum dolor, sit amet consectetur adipisicing elit.</p></li>
                <li><p class="mb-0">Lorem ipsum dolor, sit amet consectetur adipisicing elit.</p></li>
            </ul>

            <h3>Where can I get some?</h3>

            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p>
        </div>
    </div>
</section>
@endsection