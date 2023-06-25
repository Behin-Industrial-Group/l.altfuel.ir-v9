<?php

namespace Mkhodroo\AltfuelTicket\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentAttachments extends Model
{
    use HasFactory;
    public $table = "altfuel_comment_attachments";
    protected $fillable = [
        'comment_id', 'file'
    ];

    function comment() {
        return TicketComment::find($this->comment_id);
    }
}
