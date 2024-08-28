<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Mail\EmailVerification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class EmailVerifyController extends Controller
{
    public function sendMail(){
        Mail::to(auth()->user())->send(new EmailVerification(auth()->user()));
        
        return response()->json([
            "message" => "Email verification link successfully sent to your email."
        ], 200);
    }

    public function verify(Request $request){
        if(!$request->user()->email_verified_at){
            $request->user()->email_verified_at = now();
            $request->user()->save();

            return response()->json([
                "message" => "Email Verified"
            ], 200);
        }else{
            return response()->json([
                "message" => "Email Already Verified"
            ], 200);
        }
    }
}
