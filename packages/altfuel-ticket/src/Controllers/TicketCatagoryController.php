<?php

namespace Mkhodroo\AltfuelTicket\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mkhodroo\AltfuelTicket\Models\Ticket;
use Mkhodroo\AltfuelTicket\Models\TicketCatagory;

class TicketCatagoryController extends Controller
{
    function get($id){
        return TicketCatagory::find($id);
    }

    function getAll() {
        return TicketCatagory::get();
    }

    function getChildrenByParentId($parent_id = null) {
        return TicketCatagory::where('parent_id', $parent_id)->get();
    }

    function getAllParent() {
        return TicketCatagory::whereRaw('parent_id = id')->get();
    }


    function changeCatagory(Request $r) {
        $ticket = GetTicketController::findByTicketId($r->ticket_id);
        $ticket->cat_id = $r->catagory;
        $ticket->save();

        // ADD TICKET CATAGORY CHANGE TEXT IN COMMENTS
        $catagory = $this->get($ticket->cat_id);
        $text = trans('ATTrans.change-catagory-text', [ 
            'parent_cat' => $this->get($catagory->parent_id)->name, 
            'child_cat' => $catagory->name 
        ]);
        AddTicketCommentController::add($ticket->id, $text);
        return $r->ticket_id;
    }

    function count(Request $r, $id) {
        if($id){
            return Ticket::where('cat_id', $id)->where('status', config('ATConfig.status.new'))->count();
        }
        return Ticket::where('cat_id', $r->id)->where('status', config('ATConfig.status.new'))->count();
    }
}
