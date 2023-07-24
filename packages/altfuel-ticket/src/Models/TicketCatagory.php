<?php

namespace Mkhodroo\AltfuelTicket\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketCatagory extends Model
{
    use HasFactory;
    public $table = "altfuel_ticket_catagories";

    function countNews() {
        return Ticket::where('cat_id', $this->id)->where('status', config('ATConfig.status.new'))->count();
    }
}
