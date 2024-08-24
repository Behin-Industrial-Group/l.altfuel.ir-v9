<?php

namespace Mkhodroo\UserRoles\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mkhodroo\UserRoles\Models\User;

class DisableUserController extends Controller
{
    public function enable(Request $request){
        User::where('id', $request->id)->update(['disabled' => 0]);
    }

    public function disable(Request $request){
        User::where('id', $request->id)->update(['disabled' => 1]);
    }

}
