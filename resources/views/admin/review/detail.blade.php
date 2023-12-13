@extends('admin.layout.app')
@section('page-title', 'Review detail')

@section('section')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row mb-3">
                            <div class="col-md-12 text-right">
                                <a href="{{ url()->previous() }}" class="btn btn-sm btn-primary"> <i class="fa fa-chevron-left"></i> Back</a>

                                <a href="{{ route('admin.review.edit', $data->id) }}" class="btn btn-sm btn-primary"> <i class="fa fa-edit"></i> Edit</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="small text-muted mb-0">Product</p>
                        @if ($data->productDetails)
                            <div class="d-flex mb-3">
                                <div class="image-holder mr-3">
                                    <a href="{{ route('admin.product.detail', $data->productDetails->id) }}">
                                    @if (count($data->productDetails->frontImageDetails) > 0)
                                        <img src="{{ asset($data->productDetails->frontImageDetails[0]->img_large) }}" style="height:50px">
                                    @else
                                        <img src="{{ asset('frontend-assets/img/logo.png') }}" style="height:50px">
                                    @endif
                                    </a>
                                </div>
                                <div class="other-details">
                                    @if ($data->productDetails->title)
                                        <p class="text-muted mb-1"><a href="{{ route('admin.product.detail', $data->productDetails->id) }}">{{ $data->productDetails->title }}</a></p>
                                    @endif
                                    {!! productCategories($data->id, 1, 'horizontal') !!}
                                </div>
                            </div>
                        @endif

                        <p class="small text-muted mb-0">User</p>
                        <p class="small text-dark mb-2">
                            {{ $data->name }}
                             - 
                            <span class="font-weight-bold">{{ ($data->guest_review == 1) ? 'GUEST USER' : 'EXISTING USER' }}</span>
                        </p>
                        <p class="small text-dark mb-0">
                            @if ($data->email)<i class="fas fa-envelope"></i> {{ $data->email }}@endif
                        </p>
                        <p class="small text-dark">
                            @if ($data->phone_number)<i class="fas fa-phone fa-rotate-90"></i> {{ $data->phone_number }}@endif
                        </p>

                        <p class="small text-muted mb-0">Rating</p>
                        <p class="text-{{ bootstrapRatingTypeColor($data->rating) }}">{{ $data->rating }} <i class="fas fa-star"></i> </p>

                        <p class="small text-muted mb-0">Heading</p>
                        @if ($data->heading)
                            <p class="text-dark">{!! nl2br($data->heading) !!}</p>
                        @else
                            <p class="text-danger font-weight-bold">NA</p>
                        @endif

                        <p class="small text-muted mb-0">Review</p>
                        @if ($data->review)
                            <p class="text-dark">{!! nl2br($data->review) !!}</p>
                        @else
                            <p class="text-danger font-weight-bold">NA</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

