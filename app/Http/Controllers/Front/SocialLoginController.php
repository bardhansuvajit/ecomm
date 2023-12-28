<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class SocialLoginController extends Controller
{
    public function loginWithGoogle()
    {
        $jsonStr = file_get_contents('php://input');
        $jsonObj = json_decode($jsonStr);

        if(!empty($jsonObj->request_type) && $jsonObj->request_type == 'user_auth') {
            $credential = !empty($jsonObj->credential) ? $jsonObj->credential : '';
            // Decode response payload from JWT token
            list($header, $payload, $signature) = explode (".", $credential);
            $responsePayload = json_decode(base64_decode($payload));

            if(!empty($responsePayload)) {
                $oauth_provider = 'google';
                $oauth_uid  = !empty($responsePayload->sub)?$responsePayload->sub:'';
                $name = !empty($responsePayload->name)?$responsePayload->name:'';
                $first_name = !empty($responsePayload->given_name)?$responsePayload->given_name:'';
                $last_name  = !empty($responsePayload->family_name)?$responsePayload->family_name:'';
                $email      = !empty($responsePayload->email)?$responsePayload->email:'';
                $picture    = !empty($responsePayload->picture)?$responsePayload->picture:'';

                // check if user exists in db
                $finduser = User::where('email', $email)->first();
                $redirectTo = route('front.user.profile.index');
                if($finduser) {
                    Auth::loginUsingId($finduser->id);
                } else {
                    $newUser = new User();
                    $newUser->first_name = $first_name;
                    $newUser->last_name = $last_name;
                    $newUser->email = $email;
                    $newUser->image = $picture;
                    $newUser->type = 1; // for google id
                    $newUser->password = Hash::make($email);
                    $newUser->save();
                    Auth::loginUsingId($newUser->id);
                }

                return response()->json([
                    'status' => 200,
                    'message' => 'Login successfull 2',
                    'name' => $first_name.' '.$last_name,
                    'redirect' => $redirectTo
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'Account data is not available!'
                ]);
            }
        }
    }

    public function loginWithFacebook(Request $request)
    {
        dd('here fb');

        $accessToken = $request->access_token; 

        // Verify the token (it's crucial to ensure the token is valid and came from your app)
        $appId = '1765953227175289';
        $appSecret = '97953fe829138c0399d9fe8f9597e665';
        $graphUrl = "https://graph.facebook.com/debug_token?input_token={$accessToken}&access_token={$appId}|{$appSecret}";
        
        $response = file_get_contents($graphUrl);
        $tokenInfo = json_decode($response);
        
        if(!empty($tokenInfo->data->user_id)) {
            // Token is valid, fetch user data or do other processing
            $graphUrl = "https://graph.facebook.com/v10.0/me?fields=id,name,email,gender,first_name,last_name,picture.type(large)&access_token={$accessToken}";
            $userData = json_decode(file_get_contents($graphUrl));
            if ($userData) {
                $id = $userData->id;
                $name = $userData->name;
                $email = $userData->email ?? '';
                $first_name = $userData->first_name ?? '';
                $last_name = $userData->last_name ?? '';
                $profilePictureUrl = $userData->picture->data->url ?? null;

                $finduser = User::where('facebook_id', $id)->first();
                $redirectTo = route('index');
                if($finduser){
                    Auth::loginUsingId($finduser->id);
                    return response()->json(['status'=>200, 'redirectTo'=>$redirectTo]);
                }else{
                    $newUser  = new User();
                    $newUser->facebook_id = $id;
                    $newUser->name = $name;
                    $newUser->fname = $first_name;
                    $newUser->lname = $last_name;
                    $newUser->image = $profilePictureUrl;
                    $newUser->email = $email;
                    $newUser->password = Hash::make('123456');
                    $newUser->save();
                    Auth::loginUsingId($newUser->id);
                    return response()->json(['status'=>200, 'redirectTo'=>$redirectTo]);
                }     
                // Store this information in your database or start a session, etc.
            }
        } else {
            echo "Invalid token!";
        }
    }
}
