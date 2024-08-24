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
        if ($actorId = 'random') {
            $categoryActorIds = CatagoryActor::where('cat_id', $catId)->pluck('user_id');
            $actorId = $render->actorAssigner($categoryActorIds);

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

}
