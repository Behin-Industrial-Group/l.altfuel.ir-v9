<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApiAccess
{
    use ResponseTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        if(!$request->ip()){
            return $this->jsonResponse("ip خالی است", 403);
        }
        $user = User::where('valid_ip', $request->ip())->first();
        Log::info($request->input('api_token'));
        Log::info($request->ip());
        if(!$user){
            return $this->jsonResponse('ip شما مورد تایید نیست',403);
        }
        if( !$request->input('api_token')){
            return $this->jsonResponse('توکن را نیز ارسال کنید', 403);
        }
        if($user->api_token != $request->input('api_token')){
            return $this->jsonResponse('توکن ارسالی مورد تایید نیست',403);
        }

        $now = Carbon::now();
        $diff = $now->diffInMinutes($user->updated_at);
        if($diff >= 10){
            return $this->jsonResponse("توکن منقضی شده است", 403);
        }

        return $next($request);
    }
}
