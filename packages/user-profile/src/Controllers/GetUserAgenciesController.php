<?php

namespace UserProfile\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mkhodroo\AgencyInfo\Controllers\CreateAgencyController;
use Mkhodroo\AgencyInfo\Controllers\GetAgencyController;
use Mkhodroo\AltfuelTicket\Controllers\CreateTicketController;
use Mkhodroo\AltfuelTicket\Requests\TicketRequest;

class GetUserAgenciesController extends Controller
{

    public static function get(Request $request){
        $agencies = GetAgencyController::getAllByKeyValue(['national_id', 'mobile'], [$request->national_id, $request->mobile]);
        return view('UserProfileViews::partial-views.agencies-list-table', compact('agencies'));
    }

    public static function getLocation($parent_id){
        return view('UserProfileViews::partial-views.location', compact('parent_id'));
    }

    public static function participation(TicketRequest $request){
        $participation = new CreateAgencyController();
        $participation->createByParentId('participation', 1, $request->parent_id);

        $ticket = new CreateTicketController();
        $ticket->store($request);

        return true;
    }

}
