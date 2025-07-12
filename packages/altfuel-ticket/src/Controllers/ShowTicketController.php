<?php

namespace Mkhodroo\AltfuelTicket\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mkhodroo\AltfuelTicket\Models\Ticket;
use Mkhodroo\AltfuelTicket\Models\TicketComment;

class ShowTicketController extends Controller
{
    function list(): View
    {
        // $render = new TicketAssignController();
        // $render->updateActorIdToNull();
        $myTickets = (new GetTicketController())->getMyTickets();
        return view('ATView::list', compact('myTickets'));
    }

    function show(Request $r)
    {
        return view('ATView::show')->with([
            'ticket' => GetTicketController::get($r->ticket_id)
        ]);
    }
}
