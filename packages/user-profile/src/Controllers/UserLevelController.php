<?php

namespace UserProfile\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Mkhodroo\AgencyInfo\Controllers\GetAgencyController;
use UserProfile\Models\UserProfile;

class UserLevelController extends Controller
{
    public static function levelSetter($user_id) {
        $level = 0;
        $user = UserProfile::where('user_id', $user_id)->first();
        $agencies = GetAgencyController::getAllByKeyValue(['national_id', 'mobile'], [$user?->national_id, $user?->user->email]);
        if($user?->national_id and $user?->user->mobile_verified){
            $level = 1; // customer
            if($agencies){
                $level = 2; // agency
            }
        }

        return $level;
    }
}
