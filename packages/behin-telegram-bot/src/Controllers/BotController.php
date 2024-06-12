<?php

namespace TelegramBot\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class BotController extends Controller
{
    public function chat()
    {
        Log::info("Receive Message");
        $content = file_get_contents('php://input');
        $update = json_decode($content, true);
        $chat_id = $update['message']['chat']['id'];
        $text = $update['message']['text'];
        switch ($text) {
            case "/start":
                $sentMsg = 'Hi';
                break;
            case "/command1":
                $sentMsg = 'کامند 1';
                break;
            default:
                $sentMsg = 'دستور درست را انتخاب کنید';
        }
        $result = "https://api.telegram.org/bot" . config('telgram_bot_config.TOKEN') . "/sendmessage?chat_id=$chat_id&text=$sentMsg" ;
        $result = urlencode($result);
        $return = file_get_contents($result);

        return $return;
    }
}
