<div class="address-form">
    <form action="{{ route('front.user.address.update') }}" method="post">@csrf
        <div class="row">
            <div class="col-md-6">
                <div class="data-holder mb-3">
                    <label for="full_name"><h6 class="mb-1">Full name <span class="text-muted">*</span></h6></label>

                    <input type="text" class="form-control" name="full_name" id="full_name" placeholder="Enter full name" maxlength="150" value="{{ old('full_name') ? old('full_name') : $address->full_name }}" onkeypress="return isChar(event)" required>

                    @error('full_name') <p class="text-danger">{{ $message }}</p> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="data-holder mb-3">
                    <label for="contact_no1"><h6 class="mb-1">Contact number <span class="text-muted">*</span></h6></label>

                    <input type="number" class="form-control" name="contact_no1" id="contact_no1" placeholder="Enter contact number" onkeypress="return isNumeric(event)" oninput="maxLengthCheck(this)" maxlength="10" value="{{ old('contact_no1') ? old('contact_no1') : $address->contact_no1 }}" required>

                    @error('contact_no1') <p class="text-danger">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="data-holder mb-3">
                    <label for="zipcode"><h6 class="mb-1">Zipcode <span class="text-muted">*</span></h6></label>

                    <input type="number" class="form-control" name="zipcode" id="zipcode" placeholder="Enter zipcode" onkeypress="return isNumeric(event)" oninput="maxLengthCheck(this)" maxlength="6" value="{{ old('zipcode') ? old('zipcode') : $address->zipcode }}" required>

                    @error('zipcode') <p class="text-danger">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="data-holder mb-3">
                    <label for="street_address"><h6 class="mb-1">Street address <span class="text-muted">*</span></h6></label>

                    <textarea name="street_address" id="street_address" class="form-control" rows="4" placeholder="Enter street address" required>{{ old('street_address') ? old('street_address') : $address->street_address }}</textarea>

                    @error('street_address') <p class="text-danger">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="data-holder mb-3">
                    <label for="country"><h6 class="mb-1">Country <span class="text-muted">*</span></h6></label>

                    <select name="country" id="country" class="form-select" required>
                        <option value="India" 
                        {{ old('country') ? ( (old('country') == 'India') ? 'selected' : '' ) : ( ($address->country == 'India') ? 'selected' : '' ) }}
                        >India</option>
                    </select>

                    @error('country') <p class="text-danger">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="data-holder mb-3">
                    <label for="state"><h6 class="mb-1">State <span class="text-muted">*</span></h6></label>

                    <select name="state" id="state" class="form-select" required>
                        <option value="" selected disabled>Select...</option>
                        @foreach ($data->states as $state)
                            <option value="{{ $state['name'] }}" 
                            {{ old('state') ? ( (old('state') == $state['name']) ? 'selected' : '' ) : ( ($address->state == $state['name']) ? 'selected' : '' ) }}
                            >{{ $state['name'] }}</option>
                        @endforeach
                    </select>

                    @error('state') <p class="text-danger">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="data-holder mb-3">
                    <label for="city"><h6 class="mb-1">City <span class="text-muted">*</span></h6></label>

                    <select name="city" id="city" class="form-select" disabled>
                        <option value="" selected>Select state first...</option>
                    </select>

                    @error('city') <p class="text-danger">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="data-holder mb-3">
                    <label for="locality"><h6 class="mb-1">Locality <span class="text-muted">(optional)</span></h6></label>

                    <input type="text" class="form-control" name="locality" id="locality" placeholder="Enter locality" maxlength="200" value="{{ old('locality') ? old('locality') : $address->locality }}">

                    @error('locality') <p class="text-danger">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="data-holder mb-3">
                    <label for="landmark"><h6 class="mb-1">Landmark <span class="text-muted">*</span></h6></label>

                    <input type="text" class="form-control" name="landmark" id="landmark" placeholder="Enter landmark" maxlength="200" value="{{ old('landmark') ? old('landmark') : $address->landmark }}" required>

                    @error('landmark') <p class="text-danger">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="data-holder mb-3">
                    <label for="contact_no2"><h6 class="mb-1">Alternate number <span class="text-muted">(optional)</span></h6></label>

                    <input type="number" class="form-control" name="contact_no2" id="contact_no2" placeholder="Enter contact number" onkeypress="return isNumeric(event)" oninput="maxLengthCheck(this)" maxlength="10" value="{{ old('contact_no2') ? old('contact_no2') : $address->contact_no2 }}">

                    @error('contact_no2') <p class="text-danger">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="redirect-buttons">
                    <div class="d-flex">
                        @if (strpos(url()->current(), 'checkout') !== false)
                            <a data-bs-toggle="collapse" href="#addDeliveryAddress" aria-controls="addDeliveryAddress" class="btn btn-sm btn-light rounded-0">Cancel</a>
                        @endif

                        <input type="hidden" name="id" value="{{ $address->id }}">
                        <button type="submit" class="btn btn-sm btn-dark rounded-0">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>