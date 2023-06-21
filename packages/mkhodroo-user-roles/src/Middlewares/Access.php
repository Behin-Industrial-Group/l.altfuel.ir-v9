<?php

namespace Mkhodroo\UserRoles\Middlewares;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Mkhodroo\UserRoles\Controllers\AccessController;

class Access
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        if(!Auth::id()){
            return abort(403, 'ابتدا وارد شوید');
        }
        $route = $request->route()->getName() ? $request->route()->getName() : $request->route()->uri();
        $a = new AccessController($route);
        if(!$a->check()){
            return abort(403, "Forbidden For Route: " . $route);
        }

        

        return $next($request);
    }
}
