<?php

namespace Mkhodroo\AltfuelTicket\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\RandomStringController;
use BehinLogging\Controllers\LoggingController;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Mkhodroo\AltfuelTicket\Models\Ticket;
use Mkhodroo\AltfuelTicket\Models\TicketComment;

class CommentAttachmentController extends Controller
{

    private $voices_folder;

    function __construct()
    {
        $this->voices_folder = "";
    }


    public static function upload($file, $ticket_id) {
        $name = RandomStringController::Generate() . '.' . $file->getClientOriginalExtension();
        $full_path = public_path(config('ATConfig.ticket-uploads-folder'))  . "/$ticket_id";
        if ( ! is_dir($full_path)) {
            mkdir($full_path, 0777, true);
        }
        $full_name = $full_path . '/' . $name;

        $a = Storage::disk('ticket')->put($ticket_id,$file);
        $return_path = "/public". config('ATConfig.ticket-uploads-folder') . "/$a";
        return $return_path;
    }
}
