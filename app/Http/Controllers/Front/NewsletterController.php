<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\NewsletterMail;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        // dd($request->all());

        $validate = Validator::make($request->all(), [
            'mail' => 'string|email|min:5|max:200'
        ], [
            'mail.*' => 'Please enter a valid email address'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validate->errors()->first()
            ]);
        }

        $mailChk = NewsletterMail::where('email_id', $request->mail)->first();

        if (!empty($mailChk)) {
            $mailChk->count += 1;
            $mailChk->save();
        } else {
            $mail = new NewsletterMail();
            $mail->email_id = $request->mail;
            $mail->count = 1;
            $mail->save();
        }

        return response()->json([
            'status' => 200,
            'message' => 'Thank you for your interest'
        ]);
    }

}
