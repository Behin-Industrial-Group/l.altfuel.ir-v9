<?php

namespace Mkhodroo\AltfuelTicket\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mkhodroo\AltfuelTicket\Models\Ticket;
use Mkhodroo\AltfuelTicket\Models\TicketComment;

class AddTicketCommentController extends Controller
{

    public static function add($ticket_id , $text = null, $voice = null){
        return TicketComment::create([
            'user_id' => Auth::id(),
            'ticket_id' => $ticket_id,
            'text' => $text,
            'voice' => $voice
        ]);
    }
}
