@extends('admin.layout.app')
@section('page-title', 'Edit coupon')

@section('style')
    <link rel="stylesheet" href="{{ asset('packages/bootstrap-duallistbox-master/bootstrap-duallistbox.min.css') }}">
@endsection

@section('section')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row mb-3">
                            <div class="col-md-12 text-right">
                                <a href="{{ route('admin.coupon.list.all') }}" class="btn btn-sm btn-primary"> <i class="fa fa-chevron-left"></i> Back</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.coupon.update') }}" method="post">@csrf
                            <div class="form-group">
                                <label for="name">Name <span class="text-muted">*</span></label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="" value="{{ old('name') ? old('name') : $data->item->name }}" maxlength="1000">
                                @error('name') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                            <div class="form-group">
                                <label for="code">Code <span class="text-muted">*</span></label>
                                <input type="text" class="form-control" name="code" id="code" placeholder="" value="{{ old('code') ? old('code') : $data->item->code }}" maxlength="255">
                                @error('code') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label for="max_no_of_usage">Maximum no of usage <span class="text-muted">*</span></label>
                                    <input type="text" class="form-control" name="max_no_of_usage" id="max_no_of_usage" placeholder="99" value="{{ old('max_no_of_usage') ? old('max_no_of_usage') : $data->item->max_no_of_usage }}" maxlength="5">
                                    @error('max_no_of_usage') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="user_max_no_of_usage">Maximum no of usage per User <span class="text-muted">*</span></label>
                                    <input type="text" class="form-control" name="user_max_no_of_usage" id="user_max_no_of_usage" placeholder="1" value="{{ old('user_max_no_of_usage') ? old('user_max_no_of_usage') : $data->item->user_max_no_of_usage }}" maxlength="5">
                                    @error('user_max_no_of_usage') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label for="start_date">Start date <span class="text-muted">*</span></label>
                                    <input type="date" class="form-control" name="start_date" id="start_date" placeholder="" value="{{ old('start_date') ? old('start_date') : $data->item->start_date }}">
                                    @error('start_date') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="expiry_date">
                                        Expiry date <span class="text-muted">*</span>
                                        {!! (date('Y-m-d') > $data->item->expiry_date) ? '<span class="badge badge-danger">EXPIRED</span>' : '' !!}

                                        {!! (date('Y-m-d') == $data->item->expiry_date) ? '<span class="badge badge-danger">LAST DAY</span>' : '' !!}
                                    </label>
                                    <input type="date" class="form-control" name="expiry_date" id="expiry_date" placeholder="" value="{{ old('expiry_date') ? old('expiry_date') : $data->item->expiry_date }}">
                                    @error('expiry_date') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <hr>

                            @foreach ($data->currencies as $cIndex => $currency)
                                <input type="hidden" name="currency_id[]" value="{{ $currency->id }}">
                                @if ($errors->has('currency_id.'.$cIndex))
                                    <p class="small text-danger">{{ $errors->get('currency_id.'.$cIndex)[0] }}</p>
                                @endif

                                <div class="form-group row">
                                    <div class="col-12">
                                        <h5 class="text-primary font-weight-bold">
                                            {!! $currency->entity !!} - 
                                            <span>{{ strtoupper($currency->name) }}</span>
                                            <small class="text-muted">({{ $currency->full_name }})</small>
                                        </h5>
                                    </div>

                                    @php
                                        $couponDiscountData = couponDiscountData($data->item->id, $currency->id);
                                        $minCartData = minimumCartMaintainData($data->item->id, $currency->id);
                                    @endphp

                                    <div class="col-md-4">
                                        <label for="discount_amount">Discount type <span class="text-muted">*</span></label>
                                        <br>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="flat{{$cIndex}}" name="discount_type[{{$cIndex}}]" class="custom-control-input" value="1" 
                                            @if ($couponDiscountData['status'] == "success")
                                                {{ ($couponDiscountData['data']->discount_type == 1) ? 'checked' : '' }}
                                            @endif
                                            >

                                            <label class="custom-control-label" for="flat{{$cIndex}}">Flat discount</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="percentage{{$cIndex}}" name="discount_type[{{$cIndex}}]" class="custom-control-input" value="2" 
                                            @if ($couponDiscountData['status'] == "success")
                                                {{ ($couponDiscountData['data']->discount_type == 2) ? 'checked' : '' }}
                                            @endif
                                            >

                                            <label class="custom-control-label" for="percentage{{$cIndex}}">Percentage</label>
                                        </div>

                                        @if ($errors->has('discount_type.'.$cIndex))
                                            <p class="small text-danger">{{ $errors->get('discount_type.'.$cIndex)[0] }}</p>
                                        @endif
                                    </div>

                                    <div class="col-md-4">
                                        <label for="discount_amount">Discount amount <span class="text-muted">*</span></label>
                                        <input type="number" step=".01" class="form-control" name="discount_amount[]" id="discount_amount" placeholder="0.00" value="{{ old('discount_amount.'.$cIndex) ? old('discount_amount.'.$cIndex) : (($couponDiscountData['status'] == "success") ? $couponDiscountData['data']->discount_amount : '') }}">

                                        @if ($errors->has('discount_amount.'.$cIndex))
                                            <p class="small text-danger">{{ $errors->get('discount_amount.'.$cIndex)[0] }}</p>
                                        @endif
                                    </div>

                                    <div class="col-md-4">
                                        <label for="minimum_cart_amount">Minimum cart amount <span class="text-muted">(Optional)</span></label>

                                        <input type="number" step=".01" class="form-control" name="minimum_cart_amount[]" id="minimum_cart_amount" placeholder="0.00" value="{{ old('minimum_cart_amount.'.$cIndex) ? old('minimum_cart_amount.'.$cIndex) : (($minCartData['status'] == "success") ? $minCartData['data']->minimum_cart_amount : '') }}">

                                        @if ($errors->has('minimum_cart_amount.'.$cIndex))
                                            <p class="small text-danger">{{ $errors->get('minimum_cart_amount.'.$cIndex)[0] }}</p>
                                        @endif
                                    </div>
                                </div>

                                <hr>
                            @endforeach

                            <div class="form-group row">
                                <div class="col-12">
                                    <h5 class="text-primary font-weight-bold">
                                        Bind products <span class="text-muted">(Optional)</span>
                                    </h5>
                                    <p class="small text-muted">Bind this coupon only with selected products</p>
                                </div>

                                <div class="col-12">
                                    <select name="duallistbox[]" id="" multiple>
                                        @foreach ($data->products as $product)
                                            <option value="{{ $product->id }}" {{ couponProductsData($data->item->id, $product->id) }}>{{ $product->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <input type="hidden" name="id" value="{{ $data->item->id }}">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
    <script src="{{ asset('packages/bootstrap-duallistbox-master/jquery.bootstrap-duallistbox.min.js') }}"></script>

    <script>
        $('select[name="duallistbox[]"]').bootstrapDualListbox({
            moveAllLabel: 'Move all',
            removeAllLabel: 'Remove all',
        });

        $(function() {
            var customSettings = $('select[name="duallistbox[]"]').bootstrapDualListbox('getContainer');
            customSettings.find('.moveall i').removeClass().addClass('fa fa-angle-double-right').next().remove();
            customSettings.find('.removeall i').removeClass().addClass('fa fa-angle-double-left').next().remove();
        });
    </script>
@endsection
