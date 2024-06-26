<?php

namespace UserProfile\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mkhodroo\SmsTemplate\Controllers\SendSmsController;
use UserProfile\Models\MobileVerification;

class MobileVerificationController extends Controller
{
    public function codeGenerator(SendSmsController $sms)
    {
        $user = Auth::user();
        $code = rand(10000, 99999);
        $message = 'کد تایید شماره موبایل : ' . $code;
        $sms->send($user->email, $message);

        $mv = MobileVerification::create([
            'user_id' => $user->id,
            'verification_code' => $code,
            'expiration_date' => Carbon::now()->addMinute(5),
        ]);
        return true;
    }

    public function verify(Request $request)
    {
        $mv = MobileVerification::where('user_id', Auth::id())->first();
        if($request->code != $mv->verification_code){
            return response(trans("code not ok"), 403);
        }
        if(Carbon::now() > $mv->expiration_date){
            return response(trans("date not ok"), 403);
        }
        return response(trans("mobile verification ok"));
    }
}
