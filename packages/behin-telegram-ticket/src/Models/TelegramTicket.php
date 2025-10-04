<?php

namespace TelegramTicket\Models;

use Illuminate\Database\Eloquent\Model;
use TelegramTicket\Models\TelegramTicketMessage;

class TelegramTicket extends Model
{
    protected $fillable = [
        'user_id',
        'status'
    ];

    public function messages()
    {
        return $this->hasMany(TelegramTicketMessage::class, 'ticket_id')->orderBy('created_at');
    }

    public function latestMessage()
    {
        return $this->hasOne(TelegramTicketMessage::class, 'ticket_id')->latestOfMany();
    }
}
