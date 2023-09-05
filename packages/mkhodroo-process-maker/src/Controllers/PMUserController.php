<?php

namespace Mkhodroo\MkhodrooProcessMaker\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mkhodroo\MkhodrooProcessMaker\Models\PMUsers;
use Mkhodroo\MkhodrooProcessMaker\Models\PMVacation;

class PMUserController extends Controller
{
    public static function getByName($user_name) {
        return PMUsers::where('USR_USERNAME', $user_name)->first();
    }
}
