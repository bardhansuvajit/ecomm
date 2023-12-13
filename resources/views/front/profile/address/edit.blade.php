@extends('front.layout.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-9">
        <section id="orders">
            <div class="row mb-5">
                <div class="col-12">
                    <div class="page-head">
                        <div class="redirect me-3">
                            <a href="javascript: void(0)" onclick="history.back(-1)">
                                <i class="material-icons">keyboard_arrow_left</i>
                            </a>
                        </div>
                        <div class="text">
                            <h5>Edit address</h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    @php
                        $address = $data->content;
                    @endphp

                    @include('front.quick.address-edit')
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