<?php

namespace Mkhodroo\AltfuelTicket\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\RandomStringController;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Mkhodroo\AltfuelTicket\Models\CatagoryActor;
use Mkhodroo\AltfuelTicket\Models\Ticket;
use Mkhodroo\AltfuelTicket\Requests\TicketRequest;

class CreateTicketController extends Controller
{
    function index() : View {
        return view('ATView::create');
    }

    public function store(TicketRequest $r){
        if(isset($r->ticket_id)){
            $ticket = GetTicketController::findByTicketId($r->ticket_id);
        }else{//Create new Ticket
            $ticket = Ticket::create([
                'user_id' => Auth::id(),
                'ticket_id' => RandomStringController::Generate(20),
                'cat_id' => $r->catagory,
                'title' => $r->title,
                'status' => config('ATConfig.status.new')
            ]);
        }
        $status = $this->changeStatus($ticket->cat_id);
        $ticket->status = $status ? $status : $ticket->status;
        $ticket->save();
        $file_path = ($r->file('payload')) ? CommentVoiceController::upload($r->file('payload'), $ticket->ticket_id): '';

        $comment = AddTicketCommentController::add($ticket->id, $r->text , $file_path);
        Log::info("upload method " . $r->file('file'));

        if($r->file('file')){
            $attach = CommentAttachmentController::upload($r->file('file'), $ticket->ticket_id);
            AddTicketCommentAttachmentController::add($comment->id, $attach);
        }
        return response([
            'ticket' => $ticket,
            'message' => "ثبت شد"
        ], 200);
    }

    function changeStatus($cat_id, $status = '') {
        if(!CatagoryActor::where('cat_id', $cat_id)->where('user_id', Auth::id())->first()){
            return config('ATConfig.status.new');
        }
        return null;
    }
}
