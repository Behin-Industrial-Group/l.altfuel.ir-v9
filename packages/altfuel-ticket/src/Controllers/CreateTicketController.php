<?php

namespace Mkhodroo\AltfuelTicket\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\RandomStringController;
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
        if(isset($r->ticket_id)){
            $ticket = GetTicketController::findByTicketId($r->ticket_id);
            if(!$ticket){
                $ticket = Ticket::create([
                    'user_id' => Auth::id(),
                    'ticket_id' => RandomStringController::Generate(20),
                    'cat_id' => $r->catagory,
                    'title' => $r->title
                ]);
            }
        }
        $file_path = ($r->file('payload')) ? CommentVoiceController::upload($r->file('payload'), $ticket->id): '';

        AddTicketCommentController::add($ticket->id, $r->text , $file_path);
        return response([
            'ticket' => $ticket,
            'message' => "ثبت شد"
        ], 200);
    }
}
