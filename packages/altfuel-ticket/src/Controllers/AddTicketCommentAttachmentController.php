<?php

namespace Mkhodroo\AltfuelTicket\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mkhodroo\AltfuelTicket\Models\CommentAttachments;
use Mkhodroo\AltfuelTicket\Models\Ticket;
use Mkhodroo\AltfuelTicket\Models\TicketComment;

class AddTicketCommentAttachmentController extends Controller
{

    public static function add($comment_id , $file){
        return CommentAttachments::create([
            'comment_id' => $comment_id,
            'file' => $file
        ]);
    }
}
