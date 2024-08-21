<?php

namespace Mkhodroo\AltfuelTicket\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mkhodroo\AltfuelTicket\Models\CatagoryActor;
use Mkhodroo\AltfuelTicket\Models\Ticket;
use Mkhodroo\AltfuelTicket\Models\TicketCatagory;
use Mkhodroo\UserRoles\Models\User;

class TicketCatagoryController extends Controller
{
    function get($id){
        return TicketCatagory::find($id);
    }

    function modalCategory($id){
        return TicketCatagory::find($id);
    }

    function categoryForActor($id){
        return TicketCatagory::find($id);
    }

    function getAll() {
        return TicketCatagory::get();
    }

    function getChildrenByParentId($parent_id = null, $count = false) {
        if($count){
            return TicketCatagory::where('parent_id', $parent_id)->get()->each(function($row){
                $row->count = Ticket::where('cat_id', $row->id)->where('status', config('ATConfig.status.new'))->count();
            });
        }
        return TicketCatagory::where('parent_id', $parent_id)->get();
    }

    function getActorsByCatId($catId) {
        $userIds =  CatagoryActor::where('cat_id', $catId)->pluck('user_id');
        $users = User::wherein('id', $userIds)->get();
        return $users;
    }

    function getAllParent() {
        return TicketCatagory::whereRaw('parent_id = id')->get();
    }


    function changeCatagory(Request $r) {
        $ticket = GetTicketController::findByTicketId($r->ticket_id);
        if($ticket->actor_id != Auth::id()){
            return response(trans("change category access denied"), 402);
        }
        $ticket->cat_id = $r->catagory;
        $render = TicketAssignController::assign($ticket->cat_id, $ticket->id);
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
