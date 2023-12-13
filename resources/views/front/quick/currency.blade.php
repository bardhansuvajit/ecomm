<div class="offcanvas offcanvas-top" tabindex="-1" id="locationBackdrop" aria-labelledby="offcanvasBottomLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasBottomLabel">Your location</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body pt-0">
        <div class="container">
            <div class="row g-2">
                <div class="col-md">
                    <p class="text-muted small">You can change currency here</p>
                    <div class="btn-group btn-group-lg">
                        @foreach ($currencies as $index => $currency)
                            <input type="radio" class="btn-check" name="global-currency" id="currencyId{{$index}}" {{ ($existingCurrencyId == $currency->id) ? 'checked' : '' }} value="{{$currency->id}}">

                            <label class="btn btn-outline-primary" for="currencyId{{$index}}">
                                <div class="d-flex align-items-center color-inherit">
                                    <div class="flex-shrink-0">
                                        <img src="{{ asset($currency->flag) }}" alt="flag" height="50">
                                    </div>
                                    <div class="flex-grow-1 ms-3 color-inherit">
                                        <h5 class="mb-0 color-inherit">{!!$currency->entity!!} {{$currency->short_name}}</h5>
                                        <p class="mb-0 small color-inherit">{{$currency->full_name}}</p>
                                    </div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>
                <div class="col-md">
                    
                </div>
            </div>
        </div>
    </div>
</div>