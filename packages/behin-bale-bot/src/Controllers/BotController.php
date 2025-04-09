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

        $message = $update['message'] ?? null;
        $chat_id = $message['chat']['id'] ?? null;
        $text = $message['text'] ?? null;
        $contact = $message['contact'] ?? null;

        if (!$chat_id) {
            return;
        }

        $user = BaleUser::firstOrCreate(['chat_id' => $chat_id]);
        $step = $user->step;

        // هندل callback دکمه‌ها
        if (isset($update['callback_query'])) {
            return $this->handleCallback();
        }

        // هندل /start
        if ($text === '/start') {
            $telegram->sendMessage([
                'chat_id' => $chat_id,
                'text' => "سلام! من صفا هستم 🤖\nدستیار هوش مصنوعی شما در بله.\nلطفاً اطلاعات زیر را برای شروع وارد کنید."
            ]);

            if (!$user->name) {
                $user->update(['step' => 'awaiting_name']);
                $telegram->sendMessage([
                    'chat_id' => $chat_id,
                    'text' => "👤 لطفاً نام خود را وارد کنید:"
                ]);
                return;
            }

            if (!$user->phone) {
                $user->update(['step' => 'awaiting_phone']);
                $telegram->sendMessage([
                    'chat_id' => $chat_id,
                    'text' => "📱 لطفاً شماره تماس خود را ارسال کنید:",
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
                'text' => "✅ همه‌چیز آمادست! حالا سوالت رو بپرس."
            ]);
            return;
        }

        // مرحله دریافت نام
        if ($step === 'awaiting_name') {
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

        // مرحله دریافت شماره
        if ($step === 'awaiting_phone') {
            if ($contact && isset($contact['phone_number'])) {
                $phone = $contact['phone_number'];
            } elseif (preg_match('/^09\d{9}$/', $text)) {
                $phone = $text;
            } else {
                $telegram->sendMessage([
                    'chat_id' => $chat_id,
                    'text' => "❗ لطفاً شماره تلفن معتبر وارد کنید یا از دکمه پایین استفاده کنید:"
                ]);
                return;
            }

            $user->update(['phone' => $phone, 'step' => null]);
            $telegram->sendMessage([
                'chat_id' => $chat_id,
                'text' => "✅ شماره تماس ذخیره شد. حالا سوالت رو بپرس ✨"
            ]);
            return;
        }

        // اگر اطلاعات هنوز کامل نیست (کاربر مستقیماً پیام داده)
        if (!$user->name) {
            $user->update(['step' => 'awaiting_name']);
            $telegram->sendMessage([
                'chat_id' => $chat_id,
                'text' => "👤 لطفاً نام خود را وارد کنید:"
            ]);
            return;
        }

        if (!$user->phone) {
            $user->update(['step' => 'awaiting_phone']);
            $telegram->sendMessage([
                'chat_id' => $chat_id,
                'text' => "📱 لطفاً شماره تماس خود را ارسال کنید:",
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

        // ✅ ارسال به Langflow چون اطلاعات کامله
        $botResponse = LangflowController::run($text, $chat_id);

        // ذخیره پیام و پاسخ
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

        // ارسال پاسخ با دکمه
        $response = $telegram->sendMessage([
            'chat_id' => $chat_id,
            'text' => $botResponse . "\n\nآیا این پاسخ مفید بود؟",
            'reply_markup' => json_encode($keyboard)
        ]);

        $responseData = json_decode($response, true);
        $msgTelegramId = $responseData['result']['message_id'] ?? null;

        // ذخیره آی‌دی پیام تلگرام
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
