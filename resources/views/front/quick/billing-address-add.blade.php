<div class="address-form">
    <form action="{{ route('front.user.address.billing.store') }}" method="post">@csrf
        <div class="row">
            <div class="col-md-6">
                <div class="data-holder mb-3">
                    <label for="billing_full_name"><h6 class="mb-1">Full name <span class="text-muted">*</span></h6></label>

                    <input type="text" class="form-control" name="billing_full_name" id="billing_full_name" placeholder="Enter full name" maxlength="150" value="{{ old('billing_full_name') ? old('billing_full_name') : (auth()->guard('web')->check() ? auth()->guard('web')->user()->first_name.' '.auth()->guard('web')->user()->last_name : '') }}" onkeypress="return isChar(event)" required>

                    @error('billing_full_name') <p class="text-danger">{{ $message }}</p> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="data-holder mb-3">
                    <label for="billing_contact_no1"><h6 class="mb-1">Contact number <span class="text-muted">*</span></h6></label>

                    <input type="number" class="form-control" name="billing_contact_no1" id="billing_contact_no1" placeholder="Enter contact number" onkeypress="return isNumeric(event)" oninput="maxLengthCheck(this)" maxlength="10" value="{{ old('billing_contact_no1') ? old('billing_contact_no1') : (auth()->guard('web')->check() ? auth()->guard('web')->user()->mobile_no : '') }}" required>

                    @error('billing_contact_no1') <p class="text-danger">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="data-holder mb-3">
                    <label for="billing_zipcode"><h6 class="mb-1">Zipcode <span class="text-muted">*</span></h6></label>

                    <input type="number" class="form-control" name="billing_zipcode" id="billing_zipcode" placeholder="Enter zipcode" onkeypress="return isNumeric(event)" oninput="maxLengthCheck(this)" maxlength="6" value="{{ old('billing_zipcode') }}" required>

                    @error('billing_zipcode') <p class="text-danger">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="data-holder mb-3">
                    <label for="billing_street_address"><h6 class="mb-1">Street address <span class="text-muted">*</span></h6></label>

                    <textarea name="billing_street_address" id="billing_street_address" class="form-control" rows="4" placeholder="Enter street address" required>{{ old('billing_street_address') }}</textarea>

                    @error('billing_street_address') <p class="text-danger">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="data-holder mb-3">
                    <label for="billing_country"><h6 class="mb-1">Country <span class="text-muted">*</span></h6></label>

                    <select name="billing_country" id="billing_country" class="form-select" required>
                        <option value="India" selected>India</option>
                    </select>

                    @error('billing_country') <p class="text-danger">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="data-holder mb-3">
                    <label for="billing_state"><h6 class="mb-1">State <span class="text-muted">*</span></h6></label>

                    <select name="billing_state" id="billing_state" class="form-select" required>
                        <option value="" selected disabled>Select...</option>
                        @foreach ($data->states as $state)
                            <option value="{{ $state['name'] }}" {{ (old('billing_state') == $state['name']) ? 'selected' : '' }}>{{ $state['name'] }}</option>
                        @endforeach
                    </select>

                    @error('billing_state') <p class="text-danger">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="data-holder mb-3">
                    <label for="billing_city"><h6 class="mb-1">City <span class="text-muted">*</span></h6></label>

                    <select name="billing_city" id="billing_city" class="form-select" disabled>
                        <option value="" selected>Select state first...</option>
                    </select>

                    @error('billing_city') <p class="text-danger">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="data-holder mb-3">
                    <label for="billing_locality"><h6 class="mb-1">Locality <span class="text-muted">(optional)</span></h6></label>

                    <input type="text" class="form-control" name="billing_locality" id="billing_locality" placeholder="Enter locality" maxlength="200" value="{{ old('billing_locality') }}">

                    @error('billing_locality') <p class="text-danger">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="data-holder mb-3">
                    <label for="billing_landmark"><h6 class="mb-1">Landmark <span class="text-muted">*</span></h6></label>

                    <input type="text" class="form-control" name="billing_landmark" id="billing_landmark" placeholder="Enter landmark" maxlength="200" value="{{ old('billing_landmark') }}" required>

                    @error('billing_landmark') <p class="text-danger">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="data-holder mb-3">
                    <label for="billing_contact_no2"><h6 class="mb-1">Alternate number <span class="text-muted">(optional)</span></h6></label>

                    <input type="number" class="form-control" name="billing_contact_no2" id="billing_contact_no2" placeholder="Enter contact number" onkeypress="return isNumeric(event)" oninput="maxLengthCheck(this)" maxlength="10" value="{{ old('billing_contact_no2') }}">

                    @error('billing_contact_no2') <p class="text-danger">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="redirect-buttons">
                    <div class="d-flex">
                        @if (strpos(url()->current(), 'checkout') !== false)
                            <a data-bs-toggle="collapse" href="#addBillingAddress" aria-controls="addBillingAddress" class="btn btn-sm btn-light rounded-0">Cancel</a>
                        @endif

                        <input type="hidden" name="type2" value="billing">
                        <button type="submit" class="btn btn-sm btn-dark rounded-0">Add Billing address</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>