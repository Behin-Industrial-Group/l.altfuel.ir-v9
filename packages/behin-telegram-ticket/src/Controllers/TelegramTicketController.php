<?php

namespace TelegramTicket\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use TelegramTicket\Models\TelegramTicket;
use TelegramBot\Controllers\TelegramController;

class TelegramTicketController extends Controller
{
    public function index()
    {
        $tickets = TelegramTicket::where('status', 'open')->latest()->get();
        return view('telegram-ticket::index', compact('tickets'));
    }

    public function reply($id, Request $request)
    {
        $ticket = TelegramTicket::findOrFail($id);
        $ticket->reply = $request->input('reply');
        $ticket->status = 'closed';
        $ticket->save();

        // ارسال پیام به کاربر تلگرام
        $telegram = new TelegramController(config('telegram_bot_config.TOKEN'));
        $telegram->sendMessage([
            'chat_id' => $ticket->user_id,
            'text' => "👨‍💼 پاسخ پشتیبان:\n{$ticket->reply}"
        ]);

        return redirect()->back()->with('success', 'پاسخ ارسال شد.');
    }
}
