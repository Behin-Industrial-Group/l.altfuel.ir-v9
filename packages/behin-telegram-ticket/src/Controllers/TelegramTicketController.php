<?php

namespace TelegramTicket\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use TelegramTicket\Models\TelegramTicket;
use BaleBot\Controllers\TelegramController;

class TelegramTicketController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'open');

        if (!in_array($status, ['open', 'answered', 'closed', 'all'])) {
            $status = 'open';
        }

        $tickets = TelegramTicket::latest()
            ->when($status !== 'all', function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->get();

        return view('telegram-ticket::index', compact('tickets', 'status'));
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
        $ticket->reply = $agentReply;
        $ticket->status = 'answered';
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
