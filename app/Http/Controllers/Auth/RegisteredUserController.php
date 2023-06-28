<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\CustomClasses\Access;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Validation\ValidationException;
use Mkhodroo\UserRoles\Controllers\GetRoleController;
use Mkhodroo\UserRoles\Models\Role;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // $access = Access::check('register-user');

        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterRequest $request)
    {
        

        $user = User::create([
            'name' => $request->name,
            'display_name' => $request->name,
            'email' => $request->mobile,
            'password' => Hash::make($request->password),
            'role_id' => GetRoleController::getByName('متقاضی')?->id,
            'showInReport' => 0
        ]);

        Auth::loginUsingId($user->id);

        event(new Registered($user));

        return response(RouteServiceProvider::HOME);
    }
}
