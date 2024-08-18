<?php

namespace Mkhodroo\AltfuelTicket\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mkhodroo\AltfuelTicket\Models\CatagoryActor;
use Mkhodroo\AltfuelTicket\Models\Ticket;

class TicketAssignController extends Controller
{

    public function category(Request $request){

        $categoryActors = CatagoryActor::where('cat_id', 7)->pluck('user_id');
        
        dd('hi');
        $ticket = Ticket::where('id', $request->id)->first();
        // $actor = CatagoryActor::where('cat_id', $request->category);
        $ticket->update([
            'cat_id' => $request->category
        ]);
    }

    public function actor(Request $request){
        $ticket = Ticket::where('id', $request->id)->first();
        $ticket->update([
            'actor_id' => $request->actor
        ]);
    }

    public function categoryAndActor(Request $request){
        $ticket = Ticket::where('id', $request->id)->first();
        $ticket->update([
            'cat_id' => $request->category,
            'actor_id' => $request->actor
        ]);
    }

}
