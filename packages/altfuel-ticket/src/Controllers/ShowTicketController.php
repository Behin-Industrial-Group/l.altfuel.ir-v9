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
        $render = new TicketAssignController();
        $render->updateActorIdToNull();
        return view('ATView::list');
    }

    function show(Request $r)
    {
        return view('ATView::show')->with([
            'ticket' => GetTicketController::get($r->ticket_id)
        ]);
    }
}
