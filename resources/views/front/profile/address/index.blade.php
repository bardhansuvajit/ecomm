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
                            <h5>My address</h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                @if ($data->deliveryAddresses['status'] == 'success')
                    <div class="col-12 mb-3 address-hide-block">
                        <button class="btn btn-sm rounded-0 btn-dark" onclick="addAddress()">Add delivery address</button>
                    </div>

                    @if (count($data->deliveryAddresses['data']) > 0)
                        <div class="col-md-12 address-hide-block">
                            <p class="text-muted">These Delivery Address are added</p>
                        </div>
                        @foreach ($data->deliveryAddresses['data'] as $address)
                            <div class="col-md-4 address-hide-block">
                                <div class="card">
                                    <div class="card-body">
                                        @if ($address->type != 'not specified')
                                            <span class="badge bg-dark rounded-0 mb-3">{{ $address->type }}</span>
                                        @endif

                                        <h6>{{ $address->full_name }}</h6>
                                        <h6>{{ $address->contact_no1 }}</h6>
                                        <p class="text-muted mb-2">
                                            {{ $address->street_address }}, 
                                            {{ $address->city ? $address->city.', ' : '' }}
                                            {{ $address->zipcode }}
                                        </p>
                                        <p class="text-muted mb-2">{{ $address->state }}, {{ $address->country }}</p>

                                        <div class="content-edit">
                                            <a href="#" role="button" data-bs-toggle="dropdown">
                                                <i class="material-icons">more_vert</i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                @if ($address->default == 0)
                                                    <li>
                                                        <a class="dropdown-item" href="" onclick="defaultAddressSet({{$address->id}})">Make default</a>
                                                    </li>
                                                @else
                                                    <li class="dropdown-header"><p class="mb-0">Default Address</p></li>
                                                @endif
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('front.user.address.edit', $address->id) }}">Edit</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('front.user.address.remove', $address->id) }}">Remove</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                @else
                    <div class="col-12">
                        <div class="empty text-center address-hide-block">
                            <div class="image">
                                <img src="{{ asset('uploads/static-svgs/undraw_product_tour_re_8bai.svg') }}" alt="loading-cart" class="w-100">
                            </div>
                            <h6>No address found...</h6>
                            <p class="small text-muted">You can add delivery address for a faster checkout</p>
                            <button class="btn btn-sm rounded-0 btn-dark" onclick="addAddress()">Add delivery address</button>
                        </div>
                    </div>
                @endif
            </div>

            <div class="row add-address-block">
                <div class="col-12">

                    <div class="d-flex justify-content-end">
                        <a href="javascript: void(0)" onclick="hideAddAddress()"><h6 class="mb-3">Back</h6></a>
                    </div>

                    @include('front.quick.delivery-address-add')
                </div>
            </div>
        </section>
    </div>
</div>
@endsection

@section('script')
    <script>
        @if (request()->input('delivery-address-error'))
            addAddress();
        @endif
    </script>
@endsection