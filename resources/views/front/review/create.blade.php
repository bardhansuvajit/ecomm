@extends('front.layout.app')

@section('page-title', 'Write review')

@section('section')
<section class="review-list mb-3">
    <div class="row">
        <div class="col-12">
            <p class="display-6">Write review</p>
        </div>
        <div class="col-12">
            <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('front.home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('front.product.detail', $data->slug) }}">{{$data->title}}</a></li>
                    <li class="breadcrumb-item active fw-600" aria-current="page">Write review</li>
                </ol>
            </nav>
        </div>

        <div class="col-12">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('front.product.detail.review.post') }}" method="post" enctype="multipart/form-data">@csrf
                                <div class="rating mb-3">
                                    <label for="show_only" class="d-block mb-2 small text-muted fw-600">Product rating <span>*</span></label>
                                    <span class="star-rating star-5">
                                        <input type="radio" name="rating" value="1" {{ (old('rating') == 1) ? 'checked' : '' }}><i></i>
                                        <input type="radio" name="rating" value="2" {{ (old('rating') == 2) ? 'checked' : '' }}><i></i>
                                        <input type="radio" name="rating" value="3" {{ (old('rating') == 3) ? 'checked' : '' }}><i></i>
                                        <input type="radio" name="rating" value="4" {{ (old('rating') == 4) ? 'checked' : '' }}><i></i>
                                        <input type="radio" name="rating" value="5" {{ (old('rating') == 5) ? 'checked' : '' }}><i></i>
                                    </span>

                                    @error('rating') <p class="small text-danger">{{$message}}</p> @enderror
                                </div>

                                <div class="description mb-3">
                                    <label for="description" class="small text-muted fw-600">Description <span>*</span></label>
                                    <textarea name="description" id="description" rows="5" class="form-control" placeholder="eg: Tell us what you liked about the product">{{old('description')}}</textarea>

                                    @error('description') <p class="small text-danger">{{$message}}</p> @enderror
                                </div>

                                <div class="title mb-3">
                                    <label for="title" class="small text-muted fw-600">Title <span>(optional)</span></label>
                                    <input type="text" name="title" id="title" class="form-control" placeholder="eg: Write a review title" value="{{old('title')}}">

                                    @error('title') <p class="small text-danger">{{$message}}</p> @enderror
                                </div>

                                <div class="title mb-3">
                                    <label for="file" class="mb-2 small text-muted fw-600">Photo or video <span>(optional)</span></label>
                                    <input type="file" name="file[]" id="file" class="form-control" multiple>

                                    {{-- @if (count($errors) > 0)
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif --}}

                                    @error('file.0') <p class="small text-danger">{{$message}}</p> @enderror
                                </div>

                                <input type="hidden" name="product_id" value="{{$data->id}}">
                                <button type="submit" class="btn btn-primary">Submit review</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="product-detail">
                                <div class="row">
                                    <div class="col-3">
                                        <a href="{{ route('front.product.detail', $data->slug) }}" target="_blank">
                                            <div class="fixed-image-holder" style="height: 65px">
                                                <img src="{{ asset($data->imageDetails[0]->img_50) }}" alt="">
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-9">
                                        <a href="{{ route('front.product.detail', $data->slug) }}" target="_blank">
                                            <p class="card-text mb-2 product-title">{{$data->title}}</p>
                                        </a>

                                        <div class="d-flex">
                                            @if(!empty($data->offer_price))
                                                {{-- sell price --}}
                                                <p class="sell-price mb-0">&#8377;{{number_format($data->offer_price)}}</p>
                                                {{-- mrp --}}
                                                <p class="max-retail-price text-muted mb-0 mx-3">&#8377;{{ number_format($data->price) }}</p>
                                                <p class="discount mb-0">{{ discountCalculate($data->offer_price, $data->price) }} OFF</p>
                                            @else
                                                {{-- sell price --}}
                                                <p class="sell-price mb-0">&#8377;{{number_format($data->price)}}</p>
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
    </div>
</section>

<input type="hidden" name="product_id" value="{{$data->id}}">
<input type="hidden" name="_token" value="{{csrf_token()}}">
<input type="hidden" name="user_id" value="{{auth()->guard('web')->check() ? auth()->guard('web')->user()->id : 0}}">
@endsection

@section('script')
    <script>
    </script>
@endsection