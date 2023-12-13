<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Interfaces\AuthInterface;

class AuthController extends Controller
{
    private AuthInterface $authRepository;

    public function __construct(AuthInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function login(Request $request)
    {
        return redirect()->route('front.home', ['login' => 'true', 'redirect' => url()->previous()]);
    }

    public function check(Request $request)
    {
        // dd($request->all());

        $validate = Validator::make($request->all(), [
            'mobile_no' => 'required|integer|digits:10|exists:users,mobile_no',
            'password' => 'required',
            'redirect' => 'nullable|url|min:5'
        ], [
			'mobile_no.exists' => 'We could not find your phone number',
		]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validate->errors()->first()
            ]);
        }

        $creds = $request->only(['mobile_no', 'password', 'redirect']);
        $resp = $this->authRepository->check($creds);

        // $resp = $this->authRepository->check($request);

        // dd($resp);

        if ($resp['status'] == 'success') {
            return response()->json([
                'status' => 200,
                'message' => 'Login successfull',
                'redirect' => $resp['redirect'],
                'name' => auth()->guard('web')->user()->first_name ? auth()->guard('web')->user()->first_name : 'Profile'
            ]);

            // return redirect()->intended($resp['redirect_url'])->with('success', $resp['message']);
        } else {
            return response()->json([
                'status' => 400,
                'message' => $resp['message']
            ]);
            // return redirect()->back()->with('failure', $resp['message'])->withInput($request->all());
        }
    }

    public function register(Request $request)
    {
        return view('front.auth.register');
    }

    public function create(Request $request)
    {
        // dd($request->all());

        $validate = Validator::make($request->all(), [
            'referral_id' => 'nullable|string|min:2|max:20|exists:users,referral_code',
            'first_name' => 'nullable|string|min:2|max:255',
            'last_name' => 'nullable|string|min:2|max:255',
            'email' => 'nullable|email|min:2|max:255',
            'phone' => 'required|integer|digits:10|unique:users,mobile_no',
            'password' => 'required|string|min:2|max:30',
            'agree_to_terms' => 'nullable|in:agree',
        ], [
            'referral_id.exists' => 'Please enter valid Referral id',
            'agree_to_terms.*' => 'Please agree to terms & conditions'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'Error happened',
                'data' => $validate->errors()
            ]);
        }

        $resp = $this->authRepository->create($request->all());

        if ($resp['status'] == 'success') {
            return response()->json([
                'status' => 200,
                'message' => 'Login successfull',
                'redirect' => $resp['redirect'],
                'name' => auth()->guard('web')->user()->first_name ? auth()->guard('web')->user()->first_name : 'Profile'
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => $resp['message']
            ]);
        }

        // $referred_by = User::select('id')->where('mobile_no', $request->referral_id)->first();


        /*
        $user = new User();
        $user->first_name = $request->first_name ?? '';
        $user->last_name = $request->last_name ?? '';
        $user->email = $request->email ?? '';
        $user->mobile_no = $request->phone ?? '';
        $user->password = Hash::make($request->password);
        $user->type = 0;
        $user->referral_code = mt_rand_custom(5);
        $user->referred_by = 0;
        $save = $user->save();

        if ($save) {
            Auth::guard('web')->loginUsingId($user->id);
            return response()->json([
                'status' => 200,
                'message' => 'Registration successfull',
                'name' => $request->first_name ? $request->first_name : 'Profile'
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Something again. Try again later'
            ]);
        }
        */
    }

    public function logout()
    {
        auth()->guard('web')->logout();
        return redirect()->back()->with('success', 'Logout successfull');
    }

    public function account()
    {
        if (auth()->guard('web')->check()) {
            return view('front.profile.index');
        } else {
            return redirect()->route('front.user.login');
        }
    }

    public function profile()
    {
        if (auth()->guard('web')->check()) {
            return view('front.profile.edit.index');
        } else {
            return redirect()->route('front.user.login');
        }
    }

    public function forgotPassword(Request $request)
    {
        return view('front.auth.forgot-password');
    }

    public function forgotPasswordCheck(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'email' => 'required|email|min:2|max:255|exists:users,email'
        ]);

        $resp = $this->authRepository->forgotPasswordEmailReset($request->email);

        return redirect()->back()->with($resp['status'], $resp['message'])->withInput($request->all());
    }

    public function edit(Request $request)
    {
        // dd($request->all());

        $validate = Validator::make($request->all(), [
            'first_name' => 'required|string|min:2|max:255',
            'last_name' => 'required|string|min:2|max:255',
            'mobile_no' => 'required|integer|digits:10',
            'email' => 'required|email|min:2|max:255',
            'gender' => 'nullable|string|min:2|max:15|in:male,female',
        ]);

        if ($validate->fails()) {
            return redirect()
            ->to('user/profile?error=true')
            ->withInput($request->all())
            ->withErrors($validate->errors());
        }

        $resp = $this->authRepository->update($request->all(), auth()->guard('web')->user()->id);

        if ($resp['status'] == 'success') {
            return redirect()->route('front.user.profile.index')->with('success', $resp['message']);
        } else {
            if ($resp['type'] == 'err') {
                return redirect()
                ->to('user/profile?error=true')
                ->with('failure', $resp['message'])
                ->withInput($request->all());
            } else {
                return redirect()->back()->with('failure', $resp['message'])->withInput($request->all())->withErrors($validate->errors());
            }
        }
    }
}
