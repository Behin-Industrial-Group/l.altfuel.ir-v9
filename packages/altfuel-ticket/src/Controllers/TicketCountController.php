<?php

namespace Mkhodroo\AltfuelTicket\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mkhodroo\AltfuelTicket\Models\ActorsTicketCounter;
use Mkhodroo\AltfuelTicket\Models\CatagoryActor;
use Mkhodroo\AltfuelTicket\Models\Ticket;

class TicketCountController extends Controller
{
    public function actorAssigner($userIds)
    {
        foreach ($userIds as $userId) {
            $user = ActorsTicketCounter::where('actor_id', $userId)->first();
            if (!$user) {
                ActorsTicketCounter::create([
                    'actor_id' => $userId,
                    'count' => 0
                ]);
            }
        }
        $categoryActors = ActorsTicketCounter::whereIn('actor_id', $userIds)->get();
        $lowestCountActor = $categoryActors->sortBy('count')->first();
        $this->countPlus($lowestCountActor->actor_id);
        return $lowestCountActor->actor_id;
    }

    public function countPlus($id)
    {
        $user = ActorsTicketCounter::where('actor_id', $id)->first();
        $user->update([
            'count' => $user->count + 1
        ]);

        return true;
    }

    public function countMinus($id)
    {
        $user = ActorsTicketCounter::where('actor_id', $id)->first();
        $user->update([
            'count' => $user->count - 1
        ]);
        return true;
    }
}
