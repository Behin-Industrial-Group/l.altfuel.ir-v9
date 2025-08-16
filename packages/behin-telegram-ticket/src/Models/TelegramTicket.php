<?php

namespace TelegramTicket\Models;

use Illuminate\Database\Eloquent\Model;

class TelegramTicket extends Model
{
    protected $fillable = [
        'user_id',
        'messages',
        'reply',
        'status'
    ];
}
