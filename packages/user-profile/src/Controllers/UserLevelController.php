<?php

namespace UserProfile\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Mkhodroo\AgencyInfo\Controllers\GetAgencyController;
use UserProfile\Models\UserProfile;

class UserLevelController extends Controller
{
    public static function levelSetter($user_id) {
        $level = 0;
        $userProfile = UserProfile::where('user_id', $user_id)->first();
        $agencies = GetAgencyController::getAllByKeyValue(['national_id', 'mobile'], [$userProfile?->national_id, $userProfile?->user->email]);
        if($userProfile?->national_id and $userProfile?->user->mobile_verified){
            $level = 1; // customer
            if($agencies){
                $level = 2; // agency
                $user = Auth::user();
                $user->role_id = config('user_profile.agency_role');
                $user->save();
            }
        }

        return $level;
    }
}
