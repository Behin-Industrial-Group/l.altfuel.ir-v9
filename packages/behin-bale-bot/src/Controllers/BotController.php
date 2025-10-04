<?php

namespace BaleBot\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use BaleBot\Models\BaleUser;
use Mkhodroo\AltfuelTicket\Controllers\LangflowController;
use TelegramTicket\Models\TelegramTicket;

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
        if (isset($update['callback_query'])) {
            return $this->handleCallback($update);
        }

        $telegram = new TelegramController(config('bale_bot_config.TOKEN'));

        $message = $update['message'] ?? null;
        $chat_id = $message['chat']['id'] ?? null;
        $text = $message['text'] ?? null;
        $contact = $message['contact'] ?? null;
        $incomingMessageId = $message['message_id'] ?? null;
        $replyToPlatformId = $message['reply_to_message']['message_id'] ?? null;

        if (!$chat_id) return;

        // اگر تیکت باز برای کاربر وجود دارد، پیام را به تیکت اضافه کن
        $openTicket = TelegramTicket::where('user_id', $chat_id)->whereIn('status', ['open', 'answered'])->first();
        if ($openTicket) {
            if ($incomingMessageId && $openTicket->messages()->where('platform_message_id', $incomingMessageId)->exists()) {
                Log::info("Duplicate ticket message ignored: $incomingMessageId");
                return;
            }

            $replyTarget = null;
            if ($replyToPlatformId) {
                $replyTarget = $openTicket->messages()
                    ->where('platform_message_id', $replyToPlatformId)
                    ->first();
            }

            $messageContent = $text ?? '[بدون متن]';

            $openTicket->messages()->create([
                'sender_id' => $chat_id,
                'sender_type' => 'user',
                'message' => $messageContent,
                'reply_to_message_id' => $replyTarget?->id,
                'platform_message_id' => $incomingMessageId,
            ]);

            $openTicket->status = 'open';
            $openTicket->save();

            $ackPayload = [
                'chat_id' => $chat_id,
                'text' => 'پیام شما به پشتیبانی ارسال شد. منتظر پاسخ کارشناس باشید.'
            ];

            if ($incomingMessageId) {
                $ackPayload['reply_to_message_id'] = $incomingMessageId;
            }

            $telegram->sendMessage($ackPayload);
            return;
        }

        $user = BaleUser::firstOrCreate(['chat_id' => $chat_id]);

        // اگر نام کاربر وجود ندارد
        if (!$user->name) {
            // اگر متن پیام حاوی نام باشد
            if ($text !== '/start') {
                $user->name = $text;
                $user->save();

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

            // اگر هنوز نامی وارد نکرده، بپرس
            $telegram->sendMessage([
                'chat_id' => $chat_id,
                'text' => "سلام! من پاکو هستم 🤖\nدستیار هوش مصنوعی شما در بله.\nبرای شروع لطفاً نام خود را وارد کن."
            ]);
            return;
        }

        // اگر شماره تماس کاربر وجود ندارد
        if (!$user->phone) {
            // اگه کاربر شماره فرستاده
            if ($contact && isset($contact['phone_number'])) {
                $user->phone = $contact['phone_number'];
                $user->save();
            } elseif (preg_match('/^09\d{9}$/', $text)) {
                $user->phone = $text;
                $user->save();
            } else {
                $telegram->sendMessage([
                    'chat_id' => $chat_id,
                    'text' => "❗ لطفاً شماره تلفن معتبر وارد کن یا با دکمه زیر ارسال کن:",
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
                'text' => "✅ اطلاعاتت ثبت شد. حالا سوالت رو بپرس ✨"
            ]);
            return;
        }

        // اگه نام و شماره کامل بود، بفرست به Langflow
        if ($text && $text !== '/start') {
            $botResponse = LangflowController::run($text, $chat_id);

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

            $response = $telegram->sendMessage([
                'chat_id' => $chat_id,
                'text' => $botResponse,
                'reply_markup' => json_encode($keyboard)
            ]);

            $responseData = json_decode($response, true);
            $msgTelegramId = $responseData['result']['message_id'] ?? null;

            DB::table('bale_messages')->where('id', $messageId)->update([
                'telegram_message_id' => $msgTelegramId
            ]);
            return;
        }

        // فقط /start زده شده؟ معرفی کن و تمام
        if ($text === '/start') {
            $telegram->sendMessage([
                'chat_id' => $chat_id,
                'text' => "سلام {$user->name} ! من پاکو هستم 🤖\nدستیار هوش مصنوعی شما در بله.\nچه کمکی از دستم بر میاد"
            ]);
            return;
        }
    }

    public function handleCallback($update)
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

            if ($action === 'dislike') {
                $lastMessages = DB::table('bale_messages')
                    ->where('user_id', $chatId)
                    ->orderByDesc('id')
                    ->limit(3)
                    ->get()
                    ->reverse();

                $compiledMessages = "📩 پیام‌های اخیر کاربر:\n";
                foreach ($lastMessages as $msg) {
                    $compiledMessages .= "👤 کاربر: {$msg->user_message}\n🤖 ربات: {$msg->bot_response}\n\n";
                }

                // ✅ ایجاد تیکت با استفاده از مدل پکیج
                $ticket = TelegramTicket::create([
                    'user_id' => $chatId,
                    'status' => 'open',
                ]);

                foreach ($lastMessages as $msg) {
                    if (!empty($msg->user_message)) {
                        $ticket->messages()->create([
                            'sender_id' => $chatId,
                            'sender_type' => 'user',
                            'message' => $msg->user_message,
                        ]);
                    }

                    if (!empty($msg->bot_response)) {
                        $ticket->messages()->create([
                            'sender_type' => 'bot',
                            'message' => $msg->bot_response,
                            'platform_message_id' => $msg->telegram_message_id,
                        ]);
                    }
                }

                Log::info("تیکت جدید برای پشتیبانی ثبت شد:\n" . $compiledMessages);
            }

            // Only send thank you if no open ticket exists
            $hasOpenTicket = TelegramTicket::where('user_id', $chatId)->where('status', 'open')->exists();

            $telegram = new TelegramController(config('bale_bot_config.TOKEN'));

            // حذف دکمه‌ها
            $telegram->editMessageReplyMarkup([
                'chat_id' => $chatId,
                'message_id' => $msgTelegramId,
                'reply_markup' => json_encode(['inline_keyboard' => []])
            ]);

            // ارسال پیام تشکر
            if (!$hasOpenTicket) {
                $telegram->sendMessage([
                    'chat_id' => $chatId,
                    'text' => 'ممنون بابت بازخورد شما 🙏'
                ]);
            }
        }
    }
}
