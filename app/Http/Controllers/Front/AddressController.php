<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Address;
use App\Models\UserPincode;

class AddressController extends Controller
{
    public function __construct()
    {
        $this->ip = $_SERVER['REMOTE_ADDR'];
    }

    public function index(Request $request)
    {
        $data = (object) [];

        if (auth()->guard('web')->check()) {
            $data->cart = Cart::where('user_id', auth()->guard('web')->user()->id)->latest('id')->where('save_for_later', 0)->get();
            // $data->cart = Cart::where('ip', $this->ip)->orWhere('user_id', auth()->guard('web')->user()->id)->latest('id')->where('save_for_later', 0)->get();

            $data->address = Address::where('user_id', auth()->guard('web')->user()->id)->orderBy('selected', 'DESC')->get();
        } else {
            $data->cart = Cart::where('ip', $this->ip)->latest('id')->where('save_for_later', 0)->get();

            $data->address = Address::where('ip_address', $this->ip)->orderBy('selected', 'DESC')->get();
        }

        $data->user_pincode = UserPincode::where('ip_address', $this->ip)->where('selected', 1)->first();

        if (count($data->cart) > 0) {
            return view('front.checkout.address', compact('data'));
        } else {
            return redirect()->route('front.cart.index');
        }
    }

    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'full_name' => 'required|string|min:2|max:255',
            'mobile_number' => 'required|integer|digits:10',
            'email' => 'nullable|email|min:2|max:255',
            'pincode' => 'required|integer|digits:6',
            'landmark' => 'nullable|string|min:2|max:255',
            'street_address' => 'required|string|min:2|max:255',
            'locality' => 'required|string|min:2|max:255',
            'city' => 'required|string|min:2|max:255',
            'state' => 'required|string|min:2|max:255',
            'country' => 'nullable|string|min:2|max:255'
        ], [
			// 'mobile_number.digits' => 'Enter 10 digits mobile number',
			'mobile_number.*' => 'Enter 10 digits valid mobile number'
        ]);

        // check address
        $addressCheck = Address::where('user_id', auth()->guard('web')->user()->id)->where('mobile_no', $request->mobile_number)->where('pincode', $request->pincode)->where('locality', $request->locality)->first();

        if (!empty($addressCheck)) {
            return redirect()->back()->with('failure', 'This address is already added');
        }

        // address store
        $address = new Address();
        $address->user_id = auth()->guard('web')->check() ? auth()->guard('web')->user()->id : 0;
        $address->full_name = $request->full_name;
        $address->mobile_no = $request->mobile_number;
        $address->whatsapp_no = $request->whatsapp_no ?? '';
        $address->alt_no = $request->alt_no ?? '';
        $address->email = $request->email ?? '';

        $address->pincode = $request->pincode;
        $address->locality = $request->locality;
        $address->city = $request->city;
        $address->state = $request->state;
        $address->country = $request->country ?? '';
        $address->street_address = $request->street_address;
        $address->landmark = $request->landmark ?? '';
        $address->ip_address = $this->ip;
        // checking for selected/ default pincode
        $addressExists = Address::where('ip_address', $this->ip)->first();
        if (!empty($addressExists)) {
            $addressExists->selected = 0;
            $addressExists->save();
        }
        $address->selected = 1;
        $address->save();

        // adding into user pincode
        $userpinCheck = UserPincode::where('ip_address', $this->ip)->where('locality', $request->locality)->first();

        if (empty($userpinCheck)) {
            $userpin = new UserPincode();
            $userpin->ip_address = $this->ip;
            $userpin->pincode = $request->pincode;
            $userpin->locality = $request->locality;
            $userpin->city = $request->city;
            $userpin->state = $request->state;
            $userpin->country = $request->country;

            // checking for selected/ default pincode
            $userpinExists = UserPincode::where('ip_address', $this->ip)->first();
            if (!empty($userpinExists)) {
                $userpinExists->selected = 0;
                $userpinExists->save();
            }
            $userpin->selected = 1;

            $userpin->save();
        }

        return redirect()->route('front.checkout.index');
    }
}
