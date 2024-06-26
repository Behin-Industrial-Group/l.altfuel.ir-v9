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
        $mv = MobileVerification::where('user_id', Auth::id())->first();
        if (!$mv) {
            $user = Auth::user();
            $code = rand(1000, 9999);
            $message = 'کد تایید شماره موبایل : ' . $code;
            $sms->send($user->email, $message);
            $mv = MobileVerification::updateOrCreate(
                [
                    'user_id' => $user->id
                ],
                [
                    'verification_code' => $code,
                    'expiration_date' => Carbon::now()->addMinute(5)
                ]
            );
            return true;
        }

        $currentTime = Carbon::now();
        $diff = $currentTime->diffInMinutes($mv->expiration_date);
        if ($diff < 5) {
            return response(trans("code was sent"), 402);
        }
    }

    public function verify(Request $request)
    {
        $currentTime = Carbon::now();
        $diff = $currentTime->diffInMinutes($mv->expiration_date);
        $mv = MobileVerification::where('user_id', Auth::id())->first();
        if ($request->code != $mv->verification_code) {
            return response(trans("code not ok"), 402);
        }
        if ($diff > 5) {
            return response(trans("date not ok"), 402);
        }
        User::where('id', Auth::id())->update([
            'mobile_verified' => 1
        ]);
        $mv->forceDelete();
        return response(trans("mobile verification ok"));
    }
}
