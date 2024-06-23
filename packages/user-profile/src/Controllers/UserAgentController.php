<?php

namespace UserProfile\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use UserProfile\Models\UserProfile;

class UserAgentController extends Controller
{
    public static function set() {
        $profile = UserProfileController::getByUserId(Auth::id());
        $profile->user_agent = request()->userAgent();
        $profile->save();
        return ;
    }
}

