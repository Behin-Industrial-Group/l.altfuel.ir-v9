<?php

namespace Mkhodroo\AltfuelTicket\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
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
        $result = Ticket::get()->each(function ($row) {
            $row->catagory = $row->catagory();
            $row->user = $row->user()?->name;
            // $row->user_level = $row->user()->level();
        });
        return $result;
    }

    function getMyTickets()
    {
        $data = Ticket::where('user_id', Auth::id())->get()->each(function ($row) {
            $row->catagory = $row->catagory()['name'];
            $row->user = $row->user()?->name;
            // $row->user_level = $row->user()->level();
        });
        return $data;
    }

    function getMyTicketsByCatagory($catagory_id)
    {
        if (is_array($catagory_id)) {
            return Ticket::where('user_id', Auth::id())->WhereIn('cat_id', $catagory_id)->get()->each(function ($row) {
                $row->catagory = $row->catagory();
                $row->user = $row->user()?->name;
                // $row->user_level = $row->user()->level();
            });
        }
        $category = CatagoryController::get($catagory_id)->name;
        return Ticket::where('user_id', Auth::id())->where('cat_id', $catagory_id)->get()->each(function ($row) use ($category){
            $row->catagory = $category;
            $row->user = $row->user()?->name;
            // $row->user_level = $row->user()->level();
        });
    }

    function getByCatagory(Request $r)
    {
        if (auth()->user()->access("Ticket-Actors")) {
            // $actors = CatagoryActor::where('user_id', Auth::id())->pluck('cat_id');
            $category = CatagoryController::get($r->catagory)->name;
            return Ticket::where('cat_id', $r->catagory)
            ->whereIn('status', [ config('ATConfig.status.new'), config('ATConfig.status.in_progress') ])
            ->get()->each(function ($row) use ($category) {
                $row->catagory = $category;
                $row->user = $row->user()?->name;
                // $row->user_level = $row->user()->level();
            });
        }
        return $this->getMyTicketsByCatagory($r->catagory);
    }

    function oldGetByCatagory(Request $r)
    {
        if (auth()->user()->access("Ticket-Actors")) {
            // $actors = CatagoryActor::where('user_id', Auth::id())->pluck('cat_id');
            $category = CatagoryController::get($r->catagory)->name;
            return Ticket::where('cat_id', $r->catagory)
            ->whereIn('status', [ config('ATConfig.status.answered'), config('ATConfig.status.closed') ])
            ->get()->each(function ($row) use ($category) {
                $row->catagory = $category;
                $row->user = $row->user()?->name;
                // $row->user_level = $row->user()->level();
            }, 2);
        }
        return $this->getMyTicketsByCatagory($r->catagory);
    }

    function getAllByCatagory(Request $r)
    {
        if (auth()->user()->access("Ticket-Actors")) {
            // $actors = CatagoryActor::where('user_id', Auth::id())->pluck('cat_id');
            $category = CatagoryController::get($r->catagory)->name;
            return Ticket::where('cat_id', $r->catagory)
            ->get()->each(function ($row) use ($category) {
                $row->catagory = $category;
                $row->user = $row->user()?->name;
                // $row->user_level = $row->user()->level();
            }, 2);
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
