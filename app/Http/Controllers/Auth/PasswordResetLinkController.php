<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Mkhodroo\SmsTemplate\Controllers\SendSmsController;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.forgot-password');
    }

    public function sendCode(Request $r, SendSmsController $sms)
    {

    }

    /**
     * Handle an incoming password reset link request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $r, SendSmsController $sms)
    {
        $r->validate([
            'mobile' => 'required',
        ]);
        if($user = User::where('email', $r->mobile)->first()){
            $code = rand(10000, 99999);
            $sendSmsResult = $sms->send($r->mobile, str_replace(':code', $code, config('auth.messages.reset-password')));
            $user->reset_code = $code;
            $user->save();
            return true;
        }
        return throw ValidationException::withMessages([
            'mobile' => 'کاربر یافت نشد. ابتدا ثبت نام کنید'
        ]);
    }
}
