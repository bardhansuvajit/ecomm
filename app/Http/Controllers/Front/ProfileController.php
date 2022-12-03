<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Order;
use App\Models\Address;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        // dd($request->all());

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|min:2|max:255',
            'last_name' => 'required|string|min:2|max:255',
            'gender' => 'nullable|string|min:2|max:255',
            'mobile_no' => 'required|integer|digits:10',
            'email' => 'nullable|email|min:2|max:255'
        ], [
			'mobile_no.unique' => 'This mobile number is already taken',
			'mobile_no.*' => 'Enter valid mobile number'
        ]);

        if ($validator->fails()) {
            return redirect()->to(url()->previous() . '?error=true')
            ->with('failure', $validator->errors()->first())
            ->withInput($request->input())
            ->withErrors($validator);
        }

        $user = User::findOrFail(auth()->guard('web')->user()->id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->gender = $request->gender ?? 'not specified';

        // unique mobile number check
        if ($user->mobile_no != $request->mobile_no) {
            $mobile_no_chk = User::where('id', '!=', auth()->guard('web')->user()->id)->where('mobile_no', $request->mobile_no)->first();

            if (!empty($mobile_no_chk)) {
                return redirect()->to(url()->previous() . '?error=true')
                ->with('failure', 'You cannot use this mobile number')
                ->withInput($request->input());
            } else {
                $user->mobile_no = $request->mobile_no;
            }
        }

        // $user->mobile_no = $request->mobile_no;
        $user->email = $request->email ?? '';
        $user->save();

        return redirect()->route('front.user.profile.edit')->with('success', 'Profile detail updated');

        /*
        $request->validate([
            'first_name' => 'required|string|min:2|max:255',
            'last_name' => 'required|string|min:2|max:255',
            'gender' => 'nullable|string|min:2|max:255',
            'mobile_no' => 'required|integer|digits:10',
            'email' => 'nullable|email|min:2|max:255'
        ], [
			'mobile_no.unique' => 'This mobile number is already taken',
			'mobile_no.*' => 'Enter valid mobile number'
        ]);

        $user = User::findOrFail(auth()->guard('web')->user()->id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->gender = $request->gender ?? 'not specified';
        $user->mobile_no = $request->mobile_no;
        $user->email = $request->email ?? '';
        $user->save();

        return redirect()->back()->with('success', 'Profile detail updated');
        */
    }

    public function order(Request $request)
    {
        if (Auth::guard('web')->check()) {
            $data = Order::where('user_id', auth()->guard('web')->user()->id)->get();

            return view('front.profile.order', compact('data'));
        } else {
            return redirect()->route('front.user.login');
        }
    }

    public function orderDetail(Request $request, $id)
    {
        if (Auth::guard('web')->check()) {
            $data = Order::where('id', $id)->where('user_id', auth()->guard('web')->user()->id)->first();

            if (!empty($data)) {
                return view('front.profile.order-detail', compact('data'));
            } else {
                return redirect()->route('front.user.order');
            }
        } else {
            return redirect()->route('front.user.login');
        }
    }

    public function address(Request $request)
    {
        if (Auth::guard('web')->check()) {
            $data = Address::where('user_id', auth()->guard('web')->user()->id)->latest('selected')->latest('id')->get();

            return view('front.profile.address', compact('data'));
        } else {
            return redirect()->route('front.user.login');
        }
    }

    public function addressdelete(Request $request, $id)
    {
        if (Auth::guard('web')->check()) {
            $data = Address::where('id', $id)->where('user_id', auth()->guard('web')->user()->id)->delete();

            return redirect()->back()->with('success', 'Address removed');
        } else {
            return redirect()->route('front.user.login');
        }
    }

    public function wishlist(Request $request)
    {
        return view('front.profile.wishlist');
    }
}
