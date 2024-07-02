<?php

namespace UserProfile\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Mkhodroo\SmsTemplate\Controllers\SendSmsController;
use UserProfile\Models\MobileVerification;

class MobileVerificationController extends Controller
{
    public function codeGenerator(SendSmsController $sms)
    {
        $mv = MobileVerification::where('user_id', Auth::id())->first();
        $user = Auth::user();
        $code = rand(1000, 9999);
        $message = 'کد تایید شماره موبایل : ' . $code;
        if (!$mv) {
            $sms->send($user->email, $message);
            $mv = MobileVerification::create(
                [
                    'user_id' => $user->id,
                    'verification_code' => $code,
                    'expiration_date' => Carbon::now()->addMinute(5)
                ]
            );
            return response(trans("code send"));
        }

        $currentTime = Carbon::now();
        $diff = $currentTime->diffInMinutes($mv->expiration_date);
        if ($diff < config('user_profile.mobile_verification_exp_time')) {
            return response(trans("code was sent recently"));
        }

        $sms->send($user->email, $message);
        $mv->update([
            'verification_code' => $code,
            'expiration_date' => Carbon::now()->addMinute(5)
        ]);
        return response(trans("code send"));
    }

    public function verify(Request $request)
    {
        $mv = MobileVerification::where('user_id', Auth::id())->first();
        $currentTime = Carbon::now();
        $diff = $currentTime->diffInMinutes($mv->expiration_date);
        if ($request->code != $mv->verification_code) {
            return response(trans("code is not valid"), 402);
        }
        if ($diff > config('user_profile.mobile_verification_exp_time')) {
            return response(trans("code was expired"), 402);
        }
        $this->verifiedUserMobile();
        $mv->forceDelete();
        return response(trans("mobile verified"));
    }

    public function verifiedUserMobile()
    {
        return User::where('id', Auth::id())->update([
            'mobile_verified' => 1
        ]);
    }
}
