<div id="addNewAddress" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="new-address">
                    <div class="mb-3">
                        <p class="text-muted">Add new address</p>
                    </div>

                    <div id="changeAddress">
                        <form action="{{ route('address.store') }}" method="post" id="addressStoreForm">
                            <div class="row">
                                <div class="col-12"><p class="text-muted fw-700">User information</p></div>

                                <div class="col-12 col-md-6 mb-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control form-control-sm @error('full_name') is-invalid @enderror" id="full_name" placeholder="Full name" name="full_name" value="{{ auth()->guard('web')->check() ? auth()->guard('web')->user()->first_name.' '.auth()->guard('web')->user()->last_name : old('full_name') }}" autocomplete="name" maxlength="70">

                                        <label for="full_name">Full name *</label>
                                        @error('full_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 mb-3">
                                    <div class="form-floating">
                                        <input type="tel" class="form-control form-control-sm @error('mobile_number') is-invalid @enderror" id="floatingNumber" placeholder="9876XXXXX0" name="mobile_number" value="{{ auth()->guard('web')->check() ? auth()->guard('web')->user()->mobile_no : old('mobile_number') }}" autocomplete="tel">
                                        <label for="floatingNumber">Mobile number *</label>
                                        @error('mobile_number')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 mb-3">
                                    <div class="form-floating">
                                        <input type="email" class="form-control form-control-sm @error('email') is-invalid @enderror" id="floatingEmail" placeholder="name@example.com" name="email" value="{{ auth()->guard('web')->check() ? auth()->guard('web')->user()->email : old('email') }}" autocomplete="email" maxlength="70">
                                        <label for="floatingEmail">Email address</label>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12"><p class="text-muted fw-700">Address information</p></div>

                                <div class="col-12 col-md-6 mb-3">
                                    <div class="form-floating">
                                        <input type="number" class="pincode form-control form-control-sm @error('pincode') is-invalid @enderror" id="pincode" placeholder="XXXXXX" name="pincode" value="{{ $userPincode ? $userPincode->pincode : '' }}" autocomplete="postal-code">
                                        <label for="pincode">Pincode *</label>
                                        <span class="pincode-loader"></span>
                                        @error('pincode')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 mb-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control form-control-sm @error('landmark') is-invalid @enderror" id="landmark" placeholder="Enter landmark" name="landmark" value="{{ old('landmark') }}" autocomplete="landmark" maxlength="70">
                                        <label for="landmark">Landmark (optional)</label>
                                        @error('landmark')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 col-md-12 mb-3">
                                    <div class="form-floating">
                                        <textarea name="street_address" class="form-control form-control-sm @error('street_address') is-invalid @enderror" placeholder="Enter street address" id="street_address" style="min-height: 70px">{{old('street_address')}}</textarea>
                                        <label for="street_address">Street address *</label>
                                        @error('street_address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 col-md-4 mb-3">
                                    <div class="form-floating">
                                        <select class="form-select form-select-sm locality" name="locality" id="locality">
                                            {{-- @if ($data->user_pincode)
                                                <option value="{{$data->user_pincode->locality}}" selected>{{$data->user_pincode->locality}}</option>
                                            @else --}}
                                                {{-- <option>Select pincode first</option> --}}
                                            {{-- @endif --}}

                                            @if ($userPincode)
                                                <option value="{{ $userPincode->locality }}" selected>{{ $userPincode->locality }}</option>
                                            @else
                                                <option>Select pincode first</option>
                                            @endif
                                        </select>
                                        <label for="locality">Locality *</label>

                                        @error('locality')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 col-md-4 mb-3">
                                    <div class="form-floating">
                                        <input type="text" class="city form-control form-control-sm @error('city') is-invalid @enderror" id="city" placeholder="Enter city" name="city" value="{{ old('city') ? old('city') : ($userPincode ? $userPincode->city : '') }}" autocomplete="city">
                                        {{-- <input type="text" class="city form-control form-control-sm @error('city') is-invalid @enderror" id="city" placeholder="Enter city" name="city" value="{{ old('city') ? old('city') : ($data->user_pincode ? $data->user_pincode->city : '') }}" autocomplete="city"> --}}
                                        <label for="city">City/ District/ Town *</label>
                                        @error('city')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 col-md-4 mb-3">
                                    <div class="form-floating">
                                        <input type="text" class="state form-control form-control-sm @error('state') is-invalid @enderror" id="state" placeholder="Enter state" name="state" value="{{ old('state') ? old('state') : ($userPincode ? $userPincode->state : '') }}" autocomplete="state">
                                        {{-- <input type="text" class="state form-control form-control-sm @error('state') is-invalid @enderror" id="state" placeholder="Enter state" name="state" value="{{ old('state') ? old('state') : ($data->user_pincode ? $data->user_pincode->state : '') }}" autocomplete="state"> --}}
                                        <label for="state">State *</label>
                                        @error('state')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="btn-group">
                                        <input class="btn-check" type="radio" name="type" id="type_home" value="home">
                                        <label class="btn btn-sm btn-outline-secondary" for="type_home">Home</label>

                                        <input class="btn-check" type="radio" name="type" id="type_work" value="work">
                                        <label class="btn btn-sm btn-outline-secondary" for="type_work">Work</label>

                                        <input class="btn-check" type="radio" name="type" id="type_other" value="other">
                                        <label class="btn btn-sm btn-outline-secondary" for="type_other">Other</label>
                                    </div>
                                </div>

                                <div class="col-12 mt-3 text-end">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">

                                    <input type="hidden" class="country" name="country" id="country" value="{{ $userPincode ? $userPincode->country : '' }}" autocomplete="country">

                                    <input type="hidden" name="user_id" value="{{ auth()->guard('web')->check() ? auth()->guard('web')->user()->id : 0 }}">

                                    <input type="hidden" name="redirect_url" value="{{ url()->current() }}">

                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Deliver to this address</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>