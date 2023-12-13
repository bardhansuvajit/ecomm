<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Interfaces\UserAddressInterface;
use App\Interfaces\StateInterface;

class AddressController extends Controller
{
    private UserAddressInterface $userAddressRepository;
    private StateInterface $stateRepository;

    public function __construct(UserAddressInterface $userAddressRepository, StateInterface $stateRepository)
    {
        $this->userAddressRepository = $userAddressRepository;
        $this->stateRepository = $stateRepository;
    }

    public function index(Request $request)
    {
        if (auth()->guard('web')->check()) {
            $data = (object) [];

            $data->deliveryAddresses = $this->userAddressRepository->fetchDeliveryAddressesByUser(auth()->guard('web')->user()->id);
            $data->billingAddresses = $this->userAddressRepository->fetchBillingAddressesByUser(auth()->guard('web')->user()->id);
            $data->states = $this->stateRepository->stateListByCountry(101)['data'];

            return view('front.profile.address.index', compact('data'));
        } else {
            return redirect()->route('front.error.401');
        }
    }

    public function store(Request $request)
    {
        // dd($request->all());

        $validate = Validator::make($request->all(), [
            'full_name' => 'required|string|min:2|max:150',
            'contact_no1' => 'required|integer|digits:10',
            'contact_no2' => 'nullable|integer|digits:10',
            'zipcode' => 'required|integer|digits:6',
            'street_address' => 'required|string|min:2|max:1000',
            'country' => 'required|string|min:2|max:200|exists:countries,name',
            'state' => 'required|string|min:2|max:200|exists:states,name',
            'city' => 'nullable|string|min:2|max:200',
            'locality' => 'nullable|string|min:2|max:200',
            'landmark' => 'required|string|min:2|max:200',
            'type2' => 'required|string|min:2|max:200|in:delivery,billing'
        ], [
			'contact_no1.*' => 'Enter 10 digits valid contact number',
			'contact_no2.*' => 'Enter 10 digits valid contact number'
        ]);

        if($validate->fails()) {
            if (strpos(url()->previous(), 'checkout') !== false) {
                ($request->type2 == "delivery") ? $param = "delivery" : $param = "billing";

                return redirect()
                ->to('checkout?'.$param.'-address-error=true')
                ->withInput($request->all())
                ->withErrors($validate->errors());
            } elseif (strpos(url()->previous(), 'user/address') !== false) {
                ($request->type2 == "delivery") ? $param = "delivery" : $param = "billing";

                return redirect()
                ->to('user/address?'.$param.'-address-error=true')
                ->withInput($request->all())
                ->withErrors($validate->errors());
            } else {
                return redirect()
                ->back()
                ->withInput($request->all())
                ->withErrors($validate->errors());
            }
        }

        $data = $request->all() + ['user_id' => auth()->guard('web')->user()->id] + ['ip_address' => ipfetch()];
        $resp = $this->userAddressRepository->store($data);

        if ($resp['status'] == 'success') {
            if (strpos(url()->previous(), 'checkout') !== false) {
                return redirect()
                ->to('checkout')
                ->with($resp['status'], ucwords($request->type2).' address added');
            } elseif (strpos(url()->previous(), 'user/address') !== false) {
                return redirect()
                ->to('user/address')
                ->with($resp['status'], ucwords($request->type2).' address added');
            } else {
                return redirect()
                ->back()
                ->with($resp['status'], ucwords($request->type2).' address added');
            }
        } else {
            return redirect()->back()->with($resp['status'], $resp['message']);
        }
    }

    public function default(Request $request, $id)
    {
        $resp = $this->userAddressRepository->setDefault($id, auth()->guard('web')->user()->id);

        if ($resp['status'] == 'success') {
            return response()->json([
                'status' => 200,
                'message' => 'Default address updated',
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => $resp['message'],
            ]);
        }
    }

    public function billingStore(Request $request)
    {
        // dd($request->all());

        $validate = Validator::make($request->all(), [
            'billing_full_name' => 'required|string|min:2|max:150',
            'billing_contact_no1' => 'required|integer|digits:10',
            'billing_contact_no2' => 'nullable|integer|digits:10',
            'billing_zipcode' => 'required|integer|digits:6',
            'billing_street_address' => 'required|string|min:2|max:1000',
            'billing_country' => 'required|string|min:2|max:200|exists:countries,name',
            'billing_state' => 'required|string|min:2|max:200|exists:states,name',
            'billing_city' => 'nullable|string|min:2|max:200',
            'billing_locality' => 'nullable|string|min:2|max:200',
            'billing_landmark' => 'required|string|min:2|max:200',
            'type2' => 'required|string|min:2|max:200|in:delivery,billing'
        ], [
			'contact_no1.*' => 'Enter 10 digits valid contact number',
			'contact_no2.*' => 'Enter 10 digits valid contact number'
        ]);

        if($validate->fails()) {
            if (strpos(url()->previous(), 'checkout') !== false) {

                ($request->type2 == "delivery") ? $param = "delivery" : $param = "billing";

                return redirect()
                ->to('checkout?'.$param.'-address-error=true')
                ->withInput($request->all())
                ->withErrors($validate->errors());
            } else {
                return redirect()
                ->back()
                ->withInput($request->all())
                ->withErrors($validate->errors());
            }
        }

        // $data = $request->all() + ['user_id' => auth()->guard('web')->user()->id] + ['ip_address' => ipfetch()];
        $data = [
            'user_id' => auth()->guard('web')->user()->id,
            'ip_address' => ipfetch(),
            'full_name' => $request->billing_full_name,
            'contact_no1' => $request->billing_contact_no1,
            'contact_no2' => $request->billing_contact_no2 ?? '',
            'zipcode' => $request->billing_zipcode,
            'street_address' => $request->billing_street_address,
            'country' => $request->billing_country,
            'state' => $request->billing_state,
            'city' => $request->billing_city ?? '',
            'locality' => $request->billing_locality ?? '',
            'landmark' => $request->billing_landmark,
            'type' => $request->type ?? '',
            'type2' => $request->type2,
        ];
        $resp = $this->userAddressRepository->store($data);

        if ($resp['status'] == 'success') {
            if (strpos(url()->previous(), 'checkout') !== false) {
                return redirect()
                ->to('checkout')
                ->with($resp['status'], ucwords($request->type2).' address added');
            } else {
                return redirect()
                ->back()
                ->with($resp['status'], ucwords($request->type2).' address added');
            }
        } else {
            return redirect()->back()->with($resp['status'], $resp['message']);
        }
    }

    public function remove(Request $request, $id)
    {
        $resp = $this->userAddressRepository->remove($id, auth()->guard('web')->user()->id);
        return redirect()->back()->with($resp['status'], $resp['message']);

        /*
        if ($resp['status'] == 'success') {
            return response()->json([
                'status' => 200,
                'message' => 'Default address updated',
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => $resp['message'],
            ]);
        }
        */
    }

    public function edit(Request $request, $id)
    {
        $resp = $this->userAddressRepository->detail($id, auth()->guard('web')->user()->id);

        if ($resp['status'] == 'success') {
            $data = (object) [];
            $data->content = $resp['data'];
            $data->states = $this->stateRepository->stateListByCountry(101)['data'];

            return view('front.profile.address.edit', compact('data'));
        } else {
            return redirect()->route('front.error.404')->with($resp['status'], $resp['message']);
        }
    }

    public function update(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'id' => 'required|integer|min:1',
            'full_name' => 'required|string|min:2|max:150',
            'contact_no1' => 'required|integer|digits:10',
            'contact_no2' => 'nullable|integer|digits:10',
            'zipcode' => 'required|integer|digits:6',
            'street_address' => 'required|string|min:2|max:1000',
            'country' => 'required|string|min:2|max:200|exists:countries,name',
            'state' => 'required|string|min:2|max:200|exists:states,name',
            'city' => 'nullable|string|min:2|max:200',
            'locality' => 'nullable|string|min:2|max:200',
            'landmark' => 'required|string|min:2|max:200'
        ], [
			'contact_no1.*' => 'Enter 10 digits valid contact number',
			'contact_no2.*' => 'Enter 10 digits valid contact number'
        ]);

        $resp = $this->userAddressRepository->update($request->all(), auth()->guard('web')->user()->id);

        if ($resp['status'] == 'success') {
            return redirect()->route('front.user.address.index')->with($resp['status'], $resp['message']);
        } else {
            return redirect()->back()->with($resp['status'], $resp['message']);
        }
    }

}
