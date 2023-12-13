<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Interfaces\AuthInterface;

class ProfileController extends Controller
{
    private AuthInterface $authRepository;

    public function __construct(AuthInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function passwordEdit()
    {
        if (auth()->guard('web')->check()) {
            return view('front.profile.password.edit');
        } else {
            return redirect()->route('front.user.login');
        }
    }

    public function oldPassVerify(Request $request)
    {
        // dd($request->all());

        $validate = Validator::make($request->all(), [
            'oldPassword' => 'required|string|max:30',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 400, 
                'message' => $validate->errors()->first()
            ]);
        }

        $resp = $this->authRepository->verifyOldPassword($request->oldPassword, auth()->guard('web')->user()->id);

        if ($resp['status'] == 'success') {
            return response()->json([
                'status' => 200, 
                'message' => $resp['message']
            ]);
        } else {
            return response()->json([
                'status' => 400, 
                'message' => $resp['message']
            ]);
        }
    }

    public function passUpdate(Request $request)
    {
        // dd($request->all());

        $validate = Validator::make($request->all(), [
            'oldPassword' => 'required|string|max:30',
            'newPassword' => 'required|string|max:30required_with:confirmPassword|same:confirmPassword',
            'confirmPassword' => 'required|string|max:30',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 400, 
                'message' => $validate->errors()->first()
            ]);
        }

        $resp = $this->authRepository->verifyOldPassword($request->oldPassword, auth()->guard('web')->user()->id);

        if ($resp['status'] == 'success') {
            $resp2 = $this->authRepository->updatePassword($request->newPassword, auth()->guard('web')->user()->id);

            if ($resp2['status'] == 'success') {
                return response()->json([
                    'status' => 200, 
                    'message' => $resp2['message']
                ]);
            } else {
                return response()->json([
                    'status' => 400, 
                    'message' => $resp2['message']
                ]);
            }
        } else {
            return response()->json([
                'status' => 400, 
                'message' => $resp['message']
            ]);
        }
    }

    /*
    public function update(Request $request)
    {
        // dd($request->all());

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|min:2|max:255',
            'last_name' => 'required|string|min:2|max:255',
            'gender' => 'nullable|string|min:2|max:255',
            'mobile_no' => 'required|integer',
            'email' => 'required|email|min:2|max:255'
        ], [
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

        // unique mobile number check
        if ($user->email != $request->email) {
            $email_chk = User::where('id', '!=', auth()->guard('web')->user()->id)->where('email', $request->email)->first();

            if (!empty($email_chk)) {
                return redirect()->to(url()->previous() . '?error=true')
                ->with('failure', 'You cannot use this email address')
                ->withInput($request->input());
            } else {
                $user->email = $request->email;
            }
        }

        // $user->mobile_no = $request->mobile_no;
        $user->email = $request->email ?? '';
        $user->save();

        return redirect()->route('front.user.profile.edit')->with('success', 'Profile detail updated');
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
        if (Auth::guard('web')->check()) {
            $products = ProductWishlist::where('user_id', auth()->guard('web')->user()->id)->get();
            return view('front.profile.wishlist', compact('products'));

            // $data = Order::where('user_id', auth()->guard('web')->user()->id)->get();
            // return view('front.profile.order', compact('data'));
        } else {
            return redirect()->route('front.user.login');
        }
    }

    public function passwordUpdate(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'old_password' => 'required|string|min:2|max:20',
            'new_password' => 'required|string|min:2|max:20',
            'confirm_password' => 'required|string|min:2|max:20|same:new_password',
        ]);

        // if current password does not match
        if (!Hash::check($request->old_password, auth()->guard('web')->user()->password)) {
            return redirect()->back()->with('failure', 'Current password does not match');
        }

        // if current & new password are same
        if ($request->old_password == $request->new_password) {
            return redirect()->back()->with('failure', 'Current & New password can not be same');
        }

        // password update
        $loggedInAdminId = auth()->guard('web')->user()->id;

        $user = User::findOrFail($loggedInAdminId);
        $user->password = Hash::make($request->new_password);
        $user->save();
        return redirect()->back()->with('success', 'Password updated');

    }
    */
}
