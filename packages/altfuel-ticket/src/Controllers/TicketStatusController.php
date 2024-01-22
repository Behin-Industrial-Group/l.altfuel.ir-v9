<?php

namespace Mkhodroo\AltfuelTicket\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\RandomStringController;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mkhodroo\AltfuelTicket\Models\Ticket;
use Mkhodroo\AltfuelTicket\Models\TicketComment;

class TicketStatusController extends Controller
{


    public static function changeStatus(Request $r) {
        $ticket = GetTicketController::findByTicketId($r->ticket_id);
        $ticket->status = config("ATConfig.status.$r->status_key");
        $ticket->save();
        return $r->all();
    }

    public static function getStatus($id){
        $status =  GetTicketController::findByTicketId($id)->status;
        foreach( config('ATConfig.status') as $key => $value ){
            if($value === $status){
                return $key;
            }
        }
    }
}
