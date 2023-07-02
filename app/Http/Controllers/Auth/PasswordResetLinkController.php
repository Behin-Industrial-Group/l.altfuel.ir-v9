<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SMSController;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;

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

    public function sendCode(Request $r, SMSController $sms)
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
    public function store(Request $r, SMSController $sms)
    {
        $r->validate([
            'mobile' => 'required',
        ]);
        if($user = User::where('email', $r->mobile)->first()){
            $code = rand(10000, 99999);
            $sendSmsResult = $sms->send($r->mobile, config('auth.messages.reset-password'). $code);
            $user->reset_code = $code;
            $user->save();
        }
        
    }
}
