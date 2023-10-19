<?php

namespace Mkhodroo\AltfuelTicket\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Mkhodroo\AltfuelTicket\Models\CatagoryActor;
use Mkhodroo\AltfuelTicket\Models\Ticket;
use Mkhodroo\AltfuelTicket\Models\TicketComment;

class GetTicketController extends Controller
{

    function getAll()
    {
        return Ticket::get()->each(function ($row) {
            $row->catagory = $row->catagory();
            $row->user = $row->user()?->name;
        });
    }

    function getMyTickets()
    {
        return Ticket::where('user_id', Auth::id())->get()->each(function ($row) {
            $row->catagory = $row->catagory();
            $row->user = $row->user()?->name;
        });
    }

    function getMyTicketsByCatagory($catagory_id)
    {
        if (is_array($catagory_id)) {
            return Ticket::where('user_id', Auth::id())->WhereIn('cat_id', $catagory_id)->get()->each(function ($row) {
                $row->catagory = $row->catagory();
                $row->user = $row->user()?->name;
            });
        }
        return Ticket::where('user_id', Auth::id())->where('cat_id', $catagory_id)->get()->each(function ($row) {
            $row->catagory = $row->catagory();
            $row->user = $row->user()?->name;
        });
    }

    function getByCatagory(Request $r)
    {
        if (auth()->user()->access("Ticket-Actors")) {
            $actors = CatagoryActor::where('user_id', Auth::id())->pluck('cat_id');
            return Ticket::where('cat_id', $r->catagory)->WhereIn('cat_id', $actors)->get()->each(function ($row) {
                $row->catagory = $row->catagory();
                $row->user = $row->user()?->name;
            });
        }
        return $this->getMyTicketsByCatagory($r->catagory);
    }

    public static function get($id)
    {
        return Ticket::find($id);
    }

    public static function findByTicketId($ticket_id)
    {
        return Ticket::where('ticket_id', $ticket_id)->first();
    }
}
