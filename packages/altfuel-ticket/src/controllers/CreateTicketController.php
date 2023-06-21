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
        if(isset($r->title)){
            $ticket = GetTicketController::findByTitleAndUser($r->title, Auth::id());
            if(!$ticket){
                $ticket = Ticket::create([
                    'user_id' => Auth::id(),
                    'cat_id' => $r->catagory,
                    'title' => $r->title
                ]);
            }
        }
        $file_path = CommentVoiceController::upload($r->file('payload'), $ticket->id);

        AddTicketCommentController::add($ticket->id, $r->text , $file_path);
        return response()->json($ticket, 200);
    }
}
