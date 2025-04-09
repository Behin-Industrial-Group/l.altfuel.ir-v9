<?php

namespace BaleBot\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mkhodroo\AltfuelTicket\Controllers\LangflowController;

class BotController extends Controller
{
    // public function chat()
    // {
    //     Log::info("Receive Message");
    //     $content = file_get_contents('php://input');
    //     $update = json_decode($content, true);
    //     $chat_id = $update['message']['chat']['id'];
    //     $text = $update['message']['text'];
    //     // switch ($text) {
    //     //     case "/start":
    //     //         $sentMsg = 'Hi';
    //     //         break;
    //     //     case "/command1":
    //     //         $sentMsg = 'Helllo';
    //     //         break;
    //     //     default:
    //     //         $sentMsg = 'دستور درست را انتخاب کنید';
    //     // }
    //     // $url = "https://tapi.bale.ai/bot" . config('telgram_bot_config.TOKEN') . "/sendmessage";
    //     // $curl = curl_init();

    //     // curl_setopt_array($curl, array(
    //     //     CURLOPT_URL =>  $url . '?chat_id=' . $chat_id . '&text=' . $sentMsg,
    //     //     CURLOPT_RETURNTRANSFER => true,
    //     //     CURLOPT_ENCODING => '',
    //     //     CURLOPT_MAXREDIRS => 10,
    //     //     CURLOPT_TIMEOUT => 0,
    //     //     CURLOPT_FOLLOWLOCATION => true,
    //     //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //     //     CURLOPT_CUSTOMREQUEST => 'POST',
    //     // ));

    //     // $response = curl_exec($curl);
    //     // $er = curl_error($curl);
    //     // Log::info($er);
    //     // curl_close($curl);
    //     $telegram = new TelegramController(config('bale_bot_config.TOKEN'));

    //     $telegram->sendMessage(
    //         array(
    //             'chat_id' => $chat_id,
    //             'text' => "لطفا چند لحظه منتظز بمانید"
    //         )
    //     );

    //     $sentMsg = LangflowController::run($text);

    //     $telegram->sendMessage(
    //         array(
    //             'chat_id' => $chat_id,
    //             'text' => $sentMsg
    //         )
    //     );


    //     // $return = file_get_contents($result);

    // }

    public function chat()
    {
        Log::info("Receive Message");
        $content = file_get_contents('php://input');
        $update = json_decode($content, true);
        Log::info($update);


        $chat_id = $update['message']['chat']['id'];
        $text = $update['message']['text'];

        $botResponse = LangflowController::run($text);

        // ذخیره اولیه
        $messageId = DB::table('bale_messages')->insertGetId([
            'user_id' => $chat_id,
            'user_message' => $text,
            'bot_response' => $botResponse,
            'feedback' => 'none',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $keyboard = [
            'inline_keyboard' => [
                [
                    ['text' => '👍', 'callback_data' => "like:$messageId"],
                    ['text' => '👎', 'callback_data' => "dislike:$messageId"],
                ]
            ]
        ];

        $telegram = new TelegramController(config('bale_bot_config.TOKEN'));

        // ارسال پیام با دکمه
        $response = $telegram->sendMessage([
            'chat_id' => $chat_id,
            'text' => $botResponse . "\n\nآیا این پاسخ مفید بود؟",
            'reply_markup' => json_encode($keyboard)
        ]);

        $responseData = json_decode($response, true);
        $msgTelegramId = $responseData['result']['message_id'] ?? null;

        // ذخیره message_id
        DB::table('bale_messages')->where('id', $messageId)->update([
            'telegram_message_id' => $msgTelegramId
        ]);
    }

    public function handleCallback()
    {
        Log::info("Receive Callback");
        $content = file_get_contents("php://input");
        $update = json_decode($content, true);

        if (isset($update['callback_query'])) {
            Log::info($update);
            $callbackData = $update['callback_query']['data'];
            $chatId = $update['callback_query']['message']['chat']['id'];
            $msgTelegramId = $update['callback_query']['message']['message_id'];

            list($action, $msgId) = explode(':', $callbackData);

            DB::table('bale_messages')->where('id', $msgId)->update([
                'feedback' => $action,
                'updated_at' => now()
            ]);

            $telegram = new TelegramController(config('bale_bot_config.TOKEN'));

            // حذف دکمه‌ها
            $telegram->editMessageReplyMarkup([
                'chat_id' => $chatId,
                'message_id' => $msgTelegramId,
                'reply_markup' => json_encode(['inline_keyboard' => []])
            ]);

            // ارسال پیام تشکر
            $telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => 'ممنون بابت بازخورد شما 🙏'
            ]);
        }
    }


}
