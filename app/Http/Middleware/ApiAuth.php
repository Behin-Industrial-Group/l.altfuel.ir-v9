<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Traits\ResponseTrait;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ApiAuth
{
    use ResponseTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        Log::info($request->ip());
        $user = User::where('valid_ip', $request->ip())->first();
        if(!$user){
            return $this->jsonResponse("ip یافت نشد", 403);
        }

        if($user->email != $request->username){
            return $this->jsonResponse("نام کاربری یا رمز عبور صحیح نیست", 403);
        }

        if(!Hash::check($request->password, $user->password)){
            return $this->jsonResponse("نام کاربری یا رمز عبور صحیح نیست", 403);
        }
        Auth::loginUsingId($user->id);
        // if(!Auth::attempt([ 'valid_ip' => $request->ip(), 'email' => $request->username, 'password' => $request->password ])){
        //     return $this->jsonResponse("نام کاربری یا رمز عبور صحیح نیست", 403);
        // }
        return $next($request);
    }
}
