<?php

namespace BaleBot\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use BaleBot\Models\BaleUser;
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

        $telegram = new TelegramController(config('bale_bot_config.TOKEN'));

        // هندل callback دکمه‌ها
        if (isset($update['callback_query'])) {
            return $this->handleCallback();
        }

        // گرفتن پیام و اطلاعات کاربر
        $message = $update['message'];
        $chat_id = $message['chat']['id'];
        $text = $message['text'] ?? null;
        $contact = $message['contact'] ?? null;

        Log::info("Chat ID: $chat_id");

        $user = BaleUser::firstOrCreate(['chat_id' => $chat_id]);

        // اگر کاربر شماره‌اش را با دکمه فرستاده
        if ($contact && isset($contact['phone_number'])) {
            $user->update([
                'phone' => $contact['phone_number'],
                'step' => null
            ]);
            $telegram->sendMessage([
                'chat_id' => $chat_id,
                'text' => "✅ شماره تماس ذخیره شد. حالا می‌تونی سوالتو بپرسی!"
            ]);
            return;
        }

        // اگر /start زده
        if ($text === '/start') {
            $telegram->sendMessage([
                'chat_id' => $chat_id,
                'text' => "سلام! من صفا هستم 🤖\nدستیار هوش مصنوعی شما در پیام‌رسان بله!\nبیا با هم گفتگو کنیم 😉"
            ]);

            if (!$user->name) {
                $user->update(['step' => 'awaiting_name']);
                $telegram->sendMessage([
                    'chat_id' => $chat_id,
                    'text' => "لطفاً نام خود را وارد کنید:"
                ]);
                return;
            }

            if (!$user->phone) {
                $user->update(['step' => 'awaiting_phone']);
                $telegram->sendMessage([
                    'chat_id' => $chat_id,
                    'text' => "برای ادامه، لطفاً شماره تماس خود را ارسال کن:",
                    'reply_markup' => json_encode([
                        'keyboard' => [
                            [['text' => '📞 ارسال شماره من', 'request_contact' => true]]
                        ],
                        'resize_keyboard' => true,
                        'one_time_keyboard' => true
                    ])
                ]);
                return;
            }

            $telegram->sendMessage([
                'chat_id' => $chat_id,
                'text' => "همه‌چی مرتبه ✅\nسوالت رو بپرس..."
            ]);
            return;
        }

        // اگر در مرحله گرفتن نام است
        if ($user->step === 'awaiting_name') {
            $user->update(['name' => $text, 'step' => 'awaiting_phone']);
            $telegram->sendMessage([
                'chat_id' => $chat_id,
                'text' => "مرسی {$text} 🙏\nحالا لطفاً شماره تماس خود را ارسال کن:",
                'reply_markup' => json_encode([
                    'keyboard' => [
                        [['text' => '📞 ارسال شماره من', 'request_contact' => true]]
                    ],
                    'resize_keyboard' => true,
                    'one_time_keyboard' => true
                ])
            ]);
            return;
        }

        // اگر در مرحله گرفتن شماره است
        if ($user->step === 'awaiting_phone') {
            if (preg_match('/^09\d{9}$/', $text)) {
                $user->update(['phone' => $text, 'step' => null]);
                $telegram->sendMessage([
                    'chat_id' => $chat_id,
                    'text' => "✅ شماره تماس ذخیره شد. حالا می‌تونی سوالتو بپرسی!"
                ]);
            } else {
                $telegram->sendMessage([
                    'chat_id' => $chat_id,
                    'text' => "❗️شماره تماس معتبر وارد کنید (مثل 09121234567):"
                ]);
            }
            return;
        }

        // در اینجا مطمئنیم که اطلاعات کامل هست، پس می‌ریم سراغ پردازش هوش مصنوعی
        $botResponse = LangflowController::run($text, $chat_id);

        // ذخیره در دیتابیس
        $messageId = DB::table('bale_messages')->insertGetId([
            'user_id' => $chat_id,
            'user_message' => $text,
            'bot_response' => $botResponse,
            'feedback' => 'none',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // دکمه فیدبک
        $keyboard = [
            'inline_keyboard' => [
                [
                    ['text' => '👍', 'callback_data' => "like:$messageId"],
                    ['text' => '👎', 'callback_data' => "dislike:$messageId"],
                ]
            ]
        ];

        // ارسال پیام با دکمه
        $response = $telegram->sendMessage([
            'chat_id' => $chat_id,
            'text' => $botResponse . "\n\nآیا این پاسخ مفید بود؟",
            'reply_markup' => json_encode($keyboard)
        ]);

        $responseData = json_decode($response, true);
        $msgTelegramId = $responseData['result']['message_id'] ?? null;

        // ذخیره شناسه پیام
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
