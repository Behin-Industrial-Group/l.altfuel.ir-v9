<?php

namespace Mkhodroo\AltfuelTicket\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mkhodroo\AltfuelTicket\Models\Ticket;

class CreateTicketController extends Controller
{
    function index() : View {
        return view('ATView::create');
    }

    public function store(Request $r){
        CommentVoiceController::upload($r->file('payload'));
        return $r->file('payload');
        $ticket = Ticket::create([
            'user_id' => Auth::id(),
            'cat_id' => $r->catagory,
            'title' => $r->title
        ]);
        CommentVoiceController::upload($r->file(''));
        AddTicketCommentController::add($ticket->id, $r->text );
        return $r->catagory;
    }
}
