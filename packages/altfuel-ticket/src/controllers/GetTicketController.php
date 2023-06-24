<?php

namespace Mkhodroo\AltfuelTicket\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mkhodroo\AltfuelTicket\Models\Ticket;
use Mkhodroo\AltfuelTicket\Models\TicketComment;

class GetTicketController extends Controller
{

    function getAll() {
        return Ticket::get()->each(function($row){
            $row->catagory = $row->catagory();
        });
    }

    function getMyTickets() {
        return Ticket::where('user_id', Auth::id())->get()->each(function($row){
            $row->catagory = $row->catagory();
        });
    }

    function getByCatagory(Request $r) {
        return Ticket::where('cat_id', $r->catagory)->get()->each(function($row){
            $row->catagory = $row->catagory();
        });
    }

    public static function get($id) {
        return Ticket::find($id);
    }

    public static function findByTitleAndUser($title, $user_id) {
        return Ticket::where('title' , $title)->where('user_id', $user_id)->first();
    }
}
