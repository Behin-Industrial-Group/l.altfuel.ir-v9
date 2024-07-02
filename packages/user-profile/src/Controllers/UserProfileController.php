<?php

namespace UserProfile\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Mkhodroo\UserRoles\Models\Role;
use UserProfile\Models\MobileVerification;
use UserProfile\Models\UserProfile;

class UserProfileController extends Controller
{
    public function index(){
        $userAgent = request()->userAgent();
        $user = Auth::user();
        $roleName = Role::where('id', $user->role_id)->pluck('name')->first();
        return view('UserProfileViews::index')->with([
            'user' => $user,
            'userProfile' => self::getByUserId($user->id),
            'userAgent' => $userAgent,
            'roleName' => $roleName
        ]);
    }

    public static function getByUserId($user_id){
        return UserProfile::where('user_id', $user_id)->firstOrCreate([
            'user_id' => $user_id
        ]);
    }
}

