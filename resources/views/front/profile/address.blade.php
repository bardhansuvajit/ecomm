@extends('front.layout.app')

@section('page-title', 'order')

@section('section')
<section id="userAddress">
    <div class="row">
        <div class="col-12">
            <h5 class="display-6 mb-4">
                <a href="{{ route('front.user.profile') }}" class="back-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg>
                </a>
                My address
            </h5>
        </div>
    </div>

    <div class="row">
    @if (count($data) > 0)
        <div class="col-md-4 mb-2">
            <div class="card card-body text-center">
                <div class="add-new-address">
                    <img src="{{ asset('images/static-svgs/undraw_address_udes.svg') }}" alt="add-address">
                    <a href="#addNewAddress" data-bs-toggle="modal" class="btn btn-sm btn-primary">Add new address</a>

                    <p class="small text-muted mt-3 mb-0">Add addresses for a faster checkout</p>
                </div>
            </div>
        </div>

        @foreach ($data as $address)
        <div class="col-md-4 mb-2 single-address">
            <div class="card">
                <div class="card-body">
                    <div class="row g-0">
                        <div class="col-11 address-detail">
                            @if($address->selected == 1)
                                <span class="badge bg-primary rounded-0">Default</span>
                            @endif
                            @if($address->type != "not specified")
                                <span class="badge bg-secondary rounded-0">{{ strtoupper($address->type) }}</span>
                            @endif

                            <p class="mt-3 mb-0 fw-600">{{ $address->full_name }}</p>
                            <p class="mb-1 fw-600">{{ $address->mobile_no }}</p>
                            <p class="small text mb-1 text-muted">
                                {{ $address->street_address }},
                                {{ $address->city }},
                                {{ $address->pincode }},
                                {{ $address->locality }}
                            </p>
                            <p class="fw-600 text-muted">{{ $address->state }}</p>
                        </div>
                        <div class="col-1">
                            <div class="dropdown">
                                <a class="btn btn-sm btn-secondary p-1" href="javascript: void(0)" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink">
                                    <li><a class="dropdown-item small text-muted" href="javascript: void(0)" onclick="addressEdit({{$address->id}})">Edit</a></li>

                                    <li><a class="dropdown-item small text-muted" href="{{ route('front.user.address.delete', $address->id) }}" onclick="return confirm('Are you sure ?')">Remove</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    @else
        <div class="col-12 mb-4">
            <div class="card mb-4 border-0 not-found">
                <div class="card-body text-center py-4">
                    <img src="{{asset('images/static-svgs/undraw_delivery_address_re_cjca.svg')}}" alt="" height="100">

                    <h5 class="heading">No address found</h5>

                    <p class="text-muted">Add new address for a faster checkout.</p>

                    {{-- <a href="{{route('front.user.profile')}}" class="btn btn-primary">Back to Profile</a> --}}
                    <a href="#addNewAddress" data-bs-toggle="modal" class="btn btn-primary">Add new address</a>
                </div>
            </div>
        </div>
    @endif
    </div>

</section>

{{-- add new address --}}
@include('front.modal.address-create')

@include('front.modal.address-edit')
@endsection

@section('script')
    <script>
        // pincode data fetch
        $('.pincode').on('keyup', function() {
            if ($('.pincode').val().length == 6) {
                postalPinCode($('.pincode').val());
            }
        });

        // edit address
        function addressEdit(id) {
            $.ajax({
                url : "{{ route('address.detail') }}",
                method : "POST",
                data : {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    user_id: '{{ auth()->guard("web")->user()->id }}',
                },
                beforeSend: function() {
                    toastFire('info', 'Please wait...');
                },
                success: function(result) {
                    if (result.status == 200) {
                        // toastFire('success', result.message);
                        $('#edit_id').val(id);
                        $('#edit_full_name').val(result.data.full_name);
                        $('#edit_number').val(result.data.mobile_no);
                        $('#edit_email').val(result.data.email);
                        $('#edit_pincode').val(result.data.pincode);
                        $('#edit_landmark').val(result.data.landmark);
                        $('#edit_street_address').val(result.data.street_address);
                        $('#edit_city').val(result.data.city);
                        $('#edit_state').val(result.data.state);
                        $('#edit_country').val(result.data.country);

                        $('#edit_locality').html('<option disabled>Select pincode first</option><option value="'+result.data.locality+'" selected>'+result.data.locality+'</option>');

                        if (result.data.type == 'home') {
                            $('#edit_type_home').prop('checked', 'checked');
                        } else if (result.data.type == 'work') {
                            $('#edit_type_work').prop('checked', 'checked');
                        } else if (result.data.type == 'other') {
                            $('#edit_type_other').prop('checked', 'checked');
                        } else {
                            $('#edit_type_home').prop('checked', false);
                            $('#edit_type_work').prop('checked', false);
                            $('#edit_type_other').prop('checked', false);
                        }

                        Swal.close();
                        $('#editAddress').modal('show');
                    } else {
                        toastFire('error', result.message);
                    }
                }
            });
        }

        // update address
        $(document).on('submit', '#addressEditForm', function(e) {
            e.preventDefault();
            $.ajax({
                url : $(this).attr('action'),
                method : $(this).attr('method'),
                data : {
                    _token: $('input[name="_token"]').val(),
                    id: $('input[name="edit_id"]').val(),
                    redirect_url: $('input[name="edit_redirect_url"]').val(),
                    user_id: $('input[name="edit_user_id"]').val(),
                    full_name: $('input[name="edit_full_name"]').val(),
                    mobile_number: $('input[name="edit_number"]').val(),
                    email: $('input[name="edit_email"]').val(),
                    pincode: $('input[name="edit_pincode"]').val(),
                    landmark: $('input[name="edit_landmark"]').val(),
                    street_address: $('textarea[name="edit_street_address"]').val(),
                    locality: $('select[name="edit_locality"]').val(),
                    city: $('input[name="edit_city"]').val(),
                    state: $('input[name="edit_state"]').val(),
                    country: $('input[name="edit_country"]').val(),
                    type: $('input[name="edit_type"]:checked').val()
                },
                beforeSend: function() {
                    toastFire('info', 'Please wait...');
                },
                success: function(result) {
                    if (result.status == 400) {
                        toastFire('error', result.message);
                    } else {
                        toastFire('success', result.message);
                        window.location = result.redirect_url;
                    }
                }
            });
        });
    </script>
@endsection