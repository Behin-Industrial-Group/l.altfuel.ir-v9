<?php

namespace Mkhodroo\AltfuelTicket\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    public $table = "altfuel_tickets";
    protected $fillable = [
        'ticket_id', 'user_id', 'cat_id', 'title', 'status', 'junk'
    ];

    public function comments() {
        return TicketComment::where('ticket_id', $this->id)->get();
    }

    function catagory() {
        return TicketCatagory::find($this->cat_id)->only(['id', 'name']);
    }

    function user() {
        return User::find($this->user_id);
    }
}
