<?php

namespace TelegramTicket\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use TelegramTicket\Models\TelegramTicket;
use BaleBot\Controllers\TelegramController;

class TelegramTicketController extends Controller
{
    public function index()
    {
        $tickets = TelegramTicket::latest()->get();
        return view('telegram-ticket::index', compact('tickets'));
    }

    public function show($id)
    {
        $ticket = TelegramTicket::findOrFail($id);
        return view('telegram-ticket::show', compact('ticket'));
    }

    public function reply($id, Request $request)
    {
        $ticket = TelegramTicket::findOrFail($id);
        $agentReply = $request->input('reply');
        $ticket->messages .= "\n\n👨‍💼 پاسخ پشتیبان:\n" . $agentReply;
        $ticket->save();

        // ارسال پیام به کاربر تلگرام
        $telegram = new TelegramController(config('bale_bot_config.TOKEN'));
        $telegram->sendMessage([
            'chat_id' => $ticket->user_id,
            'text' => "👨‍💼 پاسخ پشتیبان:\n{$agentReply}"
        ]);

        return redirect()->route('telegram-tickets.show', $ticket->id)->with('success', 'پاسخ ارسال شد.');
    }

    public function closeTicket($id)
    {
        $ticket = TelegramTicket::findOrFail($id);
        $ticket->status = 'closed';
        $ticket->save();

        return redirect()->route('telegram-tickets.show', $ticket->id)->with('success', 'تیکت بسته شد.');
    }
}
