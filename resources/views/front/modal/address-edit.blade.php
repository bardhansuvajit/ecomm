<div id="editAddress" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="new-address">
                    <div class="mb-3">
                        <p class="text-muted">Edit address</p>
                    </div>

                    <div id="edit-address-container">
                        <form action="{{ route('address.update') }}" method="post" id="addressEditForm">
                            <div class="row">
                                <div class="col-12"><p class="text-muted fw-700">User information</p></div>

                                <div class="col-12 col-md-6 mb-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control form-control-sm" id="edit_full_name" placeholder="Full name" name="edit_full_name" value="" autocomplete="name" maxlength="70">

                                        <label for="edit_full_name">Full name *</label>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 mb-3">
                                    <div class="form-floating">
                                        <input type="tel" class="form-control form-control-sm" id="edit_number" placeholder="9876XXXXX0" name="edit_number" value="" autocomplete="tel">
                                        <label for="edit_number">Mobile number *</label>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 mb-3">
                                    <div class="form-floating">
                                        <input type="email" class="form-control form-control-sm" id="edit_email" placeholder="name@example.com" name="edit_email" value="" autocomplete="email" maxlength="70">
                                        <label for="edit_email">Email address</label>
                                    </div>
                                </div>

                                <div class="col-12"><p class="text-muted fw-700">Address information</p></div>

                                <div class="col-12 col-md-6 mb-3">
                                    <div class="form-floating">
                                        <input type="number" class="pincode form-control form-control-sm" id="edit_pincode" placeholder="XXXXXX" name="edit_pincode" value="" autocomplete="postal-code">
                                        <label for="edit_pincode">Pincode *</label>
                                        <span class="pincode-loader"></span>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 mb-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control form-control-sm" id="edit_landmark" placeholder="Enter landmark" name="edit_landmark" value="" autocomplete="landmark" maxlength="70">
                                        <label for="edit_landmark">Landmark (optional)</label>
                                    </div>
                                </div>

                                <div class="col-12 col-md-12 mb-3">
                                    <div class="form-floating">
                                        <textarea name="edit_street_address" class="form-control form-control-sm" placeholder="Enter street address" id="edit_street_address" style="min-height: 70px"></textarea>
                                        <label for="edit_street_address">Street address *</label>
                                    </div>
                                </div>

                                <div class="col-12 col-md-4 mb-3">
                                    <div class="form-floating">
                                        <select class="form-select form-select-sm locality" name="edit_locality" id="edit_locality"></select>
                                        <label for="edit_locality">Locality *</label>
                                    </div>
                                </div>

                                <div class="col-12 col-md-4 mb-3">
                                    <div class="form-floating">
                                        <input type="text" class="city form-control form-control-sm" id="edit_city" placeholder="Enter city" name="edit_city" value="" autocomplete="city">
                                        <label for="edit_city">City/ District/ Town *</label>
                                    </div>
                                </div>

                                <div class="col-12 col-md-4 mb-3">
                                    <div class="form-floating">
                                        <input type="text" class="state form-control form-control-sm" id="edit_state" placeholder="Enter state" name="edit_state" value="" autocomplete="state">
                                        <label for="edit_state">State *</label>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="btn-group">
                                        <input class="btn-check" type="radio" name="edit_type" id="edit_type_home" value="home">
                                        <label class="btn btn-sm btn-outline-secondary" for="edit_type_home">Home</label>

                                        <input class="btn-check" type="radio" name="edit_type" id="edit_type_work" value="work">
                                        <label class="btn btn-sm btn-outline-secondary" for="edit_type_work">Work</label>

                                        <input class="btn-check" type="radio" name="edit_type" id="edit_type_other" value="other">
                                        <label class="btn btn-sm btn-outline-secondary" for="edit_type_other">Other</label>
                                    </div>
                                </div>

                                <div class="col-12 mt-3 text-end">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">

                                    <input type="hidden" name="edit_country" id="edit_country" value="">

                                    <input type="hidden" name="edit_user_id" value="{{ auth()->guard('web')->check() ? auth()->guard('web')->user()->id : 0 }}">

                                    <input type="hidden" name="edit_redirect_url" value="{{ url()->current() }}">

                                    <input type="hidden" name="edit_id" id="edit_id" value="">

                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Update address details</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>