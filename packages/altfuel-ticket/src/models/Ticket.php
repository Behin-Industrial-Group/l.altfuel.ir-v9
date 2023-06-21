<?php

namespace Mkhodroo\AltfuelTicket\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    public $table = "altfuel_tickets";
    protected $fillable = [
        'user_id', 'cat_id', 'title', 'status', 'junk'
    ];

    public function comments() {
        return TicketComment::where('ticket_id', $this->id)->get();
    }
}
