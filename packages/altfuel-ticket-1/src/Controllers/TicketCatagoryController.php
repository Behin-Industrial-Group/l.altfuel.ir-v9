<?php

namespace Mkhodroo\AltfuelTicket\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mkhodroo\AltfuelTicket\Models\TicketCatagory;

class TicketCatagoryController extends Controller
{
    function getAll() {
        return TicketCatagory::get();
    }

    function getChildrenByParentId($parent_id = null) {
        return TicketCatagory::where('parent_id', $parent_id)->get();
    }

    function getAllParent() {
        return TicketCatagory::whereRaw('parent_id = id')->get();
    }
}
