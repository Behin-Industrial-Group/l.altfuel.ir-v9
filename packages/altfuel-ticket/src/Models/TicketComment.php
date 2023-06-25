<?php

namespace Mkhodroo\AltfuelTicket\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketComment extends Model
{
    use HasFactory;

    public $table = "altfuel_ticket_comments";
    protected $fillable = [
        'ticket_id', 'user_id', 'text', 'voice'
    ];

    function ticket() {
        return Ticket::find($this->ticket_id);
    }

    function user() {
        return User::find($this->user_id);
    }

    function attachments() {
        return CommentAttachments::where('comment_id', $this->id)->get();
    }
}
