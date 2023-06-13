<?php

namespace Mkhodroo\AltfuelTicket\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketComment extends Model
{
    use HasFactory;

    public $table = "altfuel_ticket_comments";
    protected $fillable = [
        'ticket_id', 'text', 'voice'
    ];
}
