<?php

namespace Mkhodroo\AltfuelTicket\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mkhodroo\AltfuelTicket\Models\CatagoryActor;
use Mkhodroo\AltfuelTicket\Models\Ticket;

class TicketCountController extends Controller
{
    public function actorFinder($catId){

        $categoryActors = CatagoryActor::where('cat_id', $catId)->pluck('user_id');


    }

    public function countPlus($id){

    }

    public function countMinus($id){
        
    }


}
