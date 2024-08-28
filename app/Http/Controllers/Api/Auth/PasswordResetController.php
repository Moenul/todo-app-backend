<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\ResetPasswordLink;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\LinkEmailRequest;
use App\Http\Requests\ResetPasswordRequest;

class PasswordResetController extends Controller
{
    public function sendResetLinkEmail(LinkEmailRequest $request){
        $url = \URL::temporarySignedRoute('password.reset', now()->addMinute(30), ["email"=>$request->email]);
        $url = str_replace(env('APP_URL'), env('FRONTEND_URL'), $url);

        Mail::to($request->email)->send(new ResetPasswordLink($url));

        return response()->json([
            "message" => "Password reset email successfully sent."
        ], 200);
    }

    public function reset(ResetPasswordRequest $request){
        $user = User::where('email', $request->email)->first();

        if(!$user){
            return response()->json([
                "message" => "User not found!"
            ], 200);
        }

        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json([
            "message" => "Password reset successfull!"
        ], 200);

    }
}
