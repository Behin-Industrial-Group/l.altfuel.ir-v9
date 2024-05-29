<?php

namespace Mkhodroo\AltfuelTicket\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Mkhodroo\AltfuelTicket\Models\TicketCatagory;

class CatagoryController extends Controller
{

    public static function get($id){
        return TicketCatagory::find($id);
    }
}
