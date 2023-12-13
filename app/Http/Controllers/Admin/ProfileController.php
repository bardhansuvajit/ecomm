<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\Models\Admin;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.profile.index');
    }

    public function update(Request $request)
    {
        // dd($request->all());

        $validator = Validator::make($request->all(), [
            'image_small' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif,svg|max:1000',
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|email|min:5|max:255',
            'mobile_no' => 'required|integer|digits:10',
            // 'username' => 'nullable|string|min:2|max:255',
            'bio' => 'nullable|string|min:5|max:1000',
            'company' => 'nullable|string|min:5|max:1000',
            'designation' => 'nullable|string|min:5|max:1000',
            'location_info' => 'nullable|string|min:5|max:1000',
            'skills' => 'nullable|string|min:5|max:1000',
            'experience' => 'nullable|string|min:5|max:1000',
        ]);

        $loggedInAdminId = auth()->guard('admin')->user()->id;

        // email id check
        $email_check = Admin::where('email', $request->email)->where('id', '!=', $loggedInAdminId)->first();
        if (!empty($email_check)) {
            return redirect()->route('admin.profile.index')
            ->with('failure', 'This email id is already taken')
            ->withInput($request->input())
            ->withErrors($validator);
        }

        // mobile number check
        $mobile_no_check = Admin::where('mobile_no', $request->mobile_no)->where('id', '!=', $loggedInAdminId)->first();
        if (!empty($mobile_no_check)) {
            return redirect()->route('admin.profile.index')
            ->with('failure', 'This mobile number is already taken')
            ->withInput($request->input())
            ->withErrors($validator);
        }

        // username check
        $username_check = Admin::where('username', $request->username)->where('id', '!=', $loggedInAdminId)->first();
        if (!empty($username_check)) {
            return redirect()->route('admin.profile.index')
            ->with('failure', 'This username is already taken')
            ->withInput($request->input())
            ->withErrors($validator);
        }

        $user = Admin::findOrFail($loggedInAdminId);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile_no = $request->mobile_no;
        // $user->username = $request->username ?? '';
        $user->bio = $request->bio ?? '';
        $user->company = $request->company ?? '';
        $user->designation = $request->designation ?? '';
        $user->location_info = $request->location_info ?? '';
        $user->skills = $request->skills ?? '';
        $user->experience = $request->experience ?? '';

        // image upload
        if (isset($request->image_small)) {
            $fileUpload1 = fileUpload($request->image_small, 'profile-image/');
            // dd($fileUpload1['file'][1]);
            $profile_img = $fileUpload1['file'][1];
            $user->image_small = $profile_img;
        }

        $user->save();

        return redirect()->route('admin.profile.index')->with('success', 'Profile detail updated');
    }

    public function password(Request $request)
    {
        return view('admin.profile.password');
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
        if (!Hash::check($request->old_password, auth()->guard('admin')->user()->password)) {
            return redirect()->route('admin.profile.password.index')->with('failure', 'Current password does not match');
        }

        // if current & new password are same
        if ($request->old_password == $request->new_password) {
            return redirect()->route('admin.profile.password.index')->with('failure', 'Current & New password can not be same');
        }

        // password update
        $loggedInAdminId = auth()->guard('admin')->user()->id;

        $user = Admin::findOrFail($loggedInAdminId);
        $user->password = Hash::make($request->new_password);
        $user->save();
        return redirect()->route('admin.profile.password.index')->with('success', 'Password updated');

    }
}
