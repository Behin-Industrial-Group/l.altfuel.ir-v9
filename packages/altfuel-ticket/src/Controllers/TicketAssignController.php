<?php

namespace Mkhodroo\AltfuelTicket\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mkhodroo\AltfuelTicket\Models\CatagoryActor;
use Mkhodroo\AltfuelTicket\Models\Ticket;

class TicketAssignController extends Controller
{
    public static function assign($catId, $ticketId, $actorId = 'random')
    {
        $render = new TicketCountController();
        if ($actorId == 'random') {
            // $categoryActorIds = CatagoryActor::where('cat_id', $catId)->pluck('user_id');
            // if (!count($categoryActorIds)) {
            //     $actorId = null;
            // } else {
            //     $actorId = $render->actorAssigner($categoryActorIds);
            // }

            $actorId = null;

            // $this->category($request);
        } else {
            $actorId = $render->actorAssigner([$actorId]);

            // $this->categoryAndActor($request);
        }
        $ticket = Ticket::where('id', $ticketId)->first();
        $ticket->update([
            'cat_id' => $catId,
            'actor_id' => $actorId
        ]);
        return true;
    }

    public function updateActorIdToNull()
    {
        $tickets = Ticket::whereNotNull('actor_id')->get();
        foreach ($tickets as $ticket) {
            $ticket->actor_id = null;
            $ticket->save();
        }

        return response()->json(['msg' => 'Actor IDs updated to null successfully!']);
    }

}
