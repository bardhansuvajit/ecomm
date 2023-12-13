@extends('admin.layout.app-product-setup')
@section('page-title', 'Product - Price')

@section('product-setup')
<form action="{{ route('admin.product.setup.store.price') }}" method="post" enctype="multipart/form-data">@csrf

    @foreach ($currencies as $cIndex => $currency)
    <input type="hidden" name="currency_id[]" value="{{ $currency->id }}">

    @if ($errors->has('currency_id.'.$cIndex))
        <p class="small text-danger">{{ $errors->get('currency_id.'.$cIndex)[0] }}</p>
    @endif

    <div class="form-group row">
        <div class="col-12">
            <h5 class="text-primary font-weight-bold">
                {!! $currency->entity !!} - 
                <span class="text-primary">{{ strtoupper($currency->name) }}</span>    
                <small class="text-muted">({{ $currency->full_name }})</small>    
            </h5>
        </div>

        <div class="col-md-4">
            <label for="cost">Cost <span class="text-muted">(Optional)</span></label>
            <input type="number" step=".01" class="form-control" name="cost[]" id="cost" placeholder="Enter cost" value="{{ old('cost.'.$cIndex) ? old('cost.'.$cIndex) : (count($productCurrencies) > 0 ? $productCurrencies[$cIndex]->cost : '') }}" {{ ($cIndex == 0) ? 'autofocus' : '' }}>
            <p class="text-muted">Helps to calculate profit</p>

            @if ($errors->has('cost.'.$cIndex))
                <p class="small text-danger">{{ $errors->get('cost.'.$cIndex)[0] }}</p>
            @endif
        </div>

        <div class="col-md-4">
            <label for="mrp">MRP <span class="text-muted">(Optional)</span></label>
            <input type="number" step=".01" class="form-control" name="mrp[]" id="mrp" placeholder="Enter MRP" value="{{ old('mrp.'.$cIndex) ? old('mrp.'.$cIndex) : (count($productCurrencies) > 0 ? $productCurrencies[$cIndex]->mrp : '') }}">
            <p class="text-muted">When you want to add discount</p>

            @if ($errors->has('mrp.'.$cIndex))
                <p class="small text-danger">{{ $errors->get('mrp.'.$cIndex)[0] }}</p>
            @endif
        </div>

        <div class="col-md-4">
            <label for="selling_price">Selling price *</label>
            <input type="number" step=".01" class="form-control" name="selling_price[]" id="selling_price" placeholder="Enter selling price" value="{{ old('selling_price.'.$cIndex) ? old('selling_price.'.$cIndex) : (count($productCurrencies) > 0 ? $productCurrencies[$cIndex]->selling_price : '') }}">

            @if ($errors->has('selling_price.'.$cIndex))
                <p class="small text-danger">{{ $errors->get('selling_price.'.$cIndex)[0] }}</p>
            @endif
        </div>
    </div>

    {{-- profit/ discount calculation --}}
    @if (count($productCurrencies) > 0)
        @if (isset($productCurrencies[$cIndex]->cost))
            <p class="font-weight-bold text-dark">
                Profit/ unit sell: 
                <span class="text-muted">{!! $currency->entity !!}{{ sprintf('%0.2f', $productCurrencies[$cIndex]->selling_price - $productCurrencies[$cIndex]->cost) }}</span>
            </p>
        @endif
        @if (isset($productCurrencies[$cIndex]->mrp))
            <p class="font-weight-bold text-dark">
                Discount: 
                <span class="text-muted">{{ discountCalculate($productCurrencies[$cIndex]->selling_price, $productCurrencies[$cIndex]->mrp) }}</span>
            </p>
        @endif
    @endif

    @if (!$loop->last) <hr> @endif

    @endforeach

    <input type="hidden" name="product_id" value="{{ $request->id }}">
    <button type="submit" class="btn btn-primary">Save &amp; Next</button>

</form>
@endsection