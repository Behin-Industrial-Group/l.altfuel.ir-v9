<?php

namespace MyAgencyInfo\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Mkhodroo\AgencyInfo\Controllers\AgencyController;
use Mkhodroo\AgencyInfo\Controllers\GetAgencyController;

class EditMyAgencyInfoController extends Controller
{

    public static function form($parent_id){
        $agency_fields = AgencyController::getAgencyFieldsByParentId($parent_id);
        return view('MyAgencyViews::edit', compact('agency_fields'));
    }

}
