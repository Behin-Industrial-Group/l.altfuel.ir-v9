<?php

namespace Mkhodroo\AltfuelTicket\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mkhodroo\AltfuelTicket\Models\Ticket;
use Mkhodroo\AltfuelTicket\Models\TicketComment;

class CommentVoiceController extends Controller
{

    private $voices_folder;

    function __construct()
    {
        $this->voices_folder = "";
    }


    public static function upload($file) {
        move_uploaded_file($file, "./audio1.wav");
        
    }
}
