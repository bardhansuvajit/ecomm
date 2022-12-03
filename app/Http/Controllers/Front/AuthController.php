<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Order;
use App\Models\Cart;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $redirect_url = url()->previous();
        return view('front.auth.login', compact('redirect_url'));
    }

    public function register(Request $request)
    {
        return view('front.auth.register');
    }

    public function create(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'first_name' => 'required|string|min:2|max:255',
            'last_name' => 'required|string|min:2|max:255',
            'mobile_no' => 'required|integer|digits:10|unique:users,mobile_no',
            'email' => 'nullable|email|min:2|max:255',
            'password' => 'required|string|max:255',
            'referral' => 'nullable|string|min:2|max:255',
        ], [
			'mobile_no.unique' => 'This mobile number is already taken',
			'mobile_no.*' => 'Enter valid mobile number'
        ]);

        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->mobile_no = $request->mobile_no;
        $user->email = $request->email ?? '';
        $user->password = Hash::make($request->password);
        // new referral code generate
        $user->referral_code = mt_rand_custom(5);
        // if other referral used
        if (!empty($request->referral)) {
            $referred_by = User::select('id')->where('referral_code', $request->referral)->first();
            if (empty($referred_by)) {
                return redirect()->back()->with('failure', 'Invalid referral code')->withInput($request->all());
            }

            $user->referred_by = $referred_by->id;
        } else {
            $user->referred_by = '';
        }

        $save = $user->save();

        $creds = array(
            'mobile_no' => $user->mobile_no,
            'password' => $request->password,
        );

        if (Auth::guard('web')->attempt($creds)) {
            return redirect()->back()->with('success', 'Registration successfull');
        } else {
            return redirect()->back()->with('failure', 'Failed to craete User')->withInput($request->all());
        }
    }

    public function check(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'mobile_no' => 'required|integer|digits:10|exists:users,mobile_no',
            'password' => 'required',
            'redirect_url' => 'nullable'
        ], [
			'mobile_no.exists' => 'We could not find your mobile number',
			'mobile_no.*' => 'Enter valid mobile number'
		]);

        $creds = $request->only('mobile_no', 'password');

        if (Auth::guard('web')->attempt($creds)) {

            // check if product exists in cookie
            if (!empty($_COOKIE['_cart-token'])) {
                $token = $_COOKIE['_cart-token'];
                $update = Cart::where('guest_token', $token)->update([
                    'user_id' => Auth::guard('web')->user()->id
                ]);
                // remove cookie
                unset($_COOKIE['_cart-token']); 
                setcookie('_cart-token', null, -1, '/'); 
            }

            if (!empty($request->redirect_url)) {
                return redirect()->to($request->redirect_url)->with('success', 'Login successfull');
            } else {
                return redirect()->route('front.user.profile')->with('success', 'Login successfull');
            }
        } else {
            return redirect()->back()->with('failure', 'Invalid credential')->withInput($request->all());
        }
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect()->back()->with('success', 'Logout successfull');
    }

    public function profile()
    {
        if (Auth::guard('web')->check()) {
            return view('front.profile.index');
        } else {
            return redirect()->route('front.user.login');
        }
    }
}
