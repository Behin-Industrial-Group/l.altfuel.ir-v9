<?php

namespace BaleBot\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use BaleBot\Models\BaleUser;
use Mkhodroo\AltfuelTicket\Controllers\LangflowController;
use TelegramTicket\Models\TelegramTicket;
use TelegramTicket\Models\TelegramTicketMessage;

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
                'platform' => 'bale',
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
            $conversationTicket = TelegramTicket::firstOrCreate(
                [
                    'user_id' => $chat_id,
                    'is_bot_generated' => true,
                ],
                [
                    'status' => 'closed',
                ]
            );

            $replyTarget = null;
            if ($replyToPlatformId) {
                $replyTarget = $conversationTicket->messages()
                    ->where('platform_message_id', $replyToPlatformId)
                    ->first();
            }

            $userMessage = null;
            if ($incomingMessageId) {
                $userMessage = $conversationTicket->messages()
                    ->where('platform_message_id', $incomingMessageId)
                    ->first();
            }

            if (!$userMessage) {
                $userMessage = $conversationTicket->messages()->create([
                    'sender_id' => $chat_id,
                    'sender_type' => 'user',
                    'message' => $text,
                    'reply_to_message_id' => $replyTarget?->id,
                    'platform_message_id' => $incomingMessageId,
                    'platform' => 'bale',
                ]);
            }

            $botResponse = LangflowController::run($text, $chat_id);

            $botMessage = $conversationTicket->messages()->create([
                'sender_type' => 'bot',
                'message' => $botResponse,
                'reply_to_message_id' => $userMessage->id,
                'platform' => 'bale',
                'feedback' => 'none',
            ]);

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['text' => '👍', 'callback_data' => "bale_feedback:like:{$botMessage->id}"],
                        ['text' => '👎', 'callback_data' => "bale_feedback:dislike:{$botMessage->id}"],
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

            if ($msgTelegramId) {
                $botMessage->platform_message_id = $msgTelegramId;
                $botMessage->save();
            }

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

        if (!isset($update['callback_query'])) {
            return;
        }

        Log::info($update);

        $callbackData = $update['callback_query']['data'] ?? '';
        if (strpos($callbackData, 'bale_feedback:') !== 0) {
            return;
        }

        $chatId = $update['callback_query']['message']['chat']['id'] ?? null;
        $msgTelegramId = $update['callback_query']['message']['message_id'] ?? null;

        $parts = explode(':', $callbackData);
        if (count($parts) !== 3) {
            return;
        }

        [, $action, $msgId] = $parts;

        $botMessage = TelegramTicketMessage::with('ticket')->find($msgId);
        if (!$botMessage || $botMessage->sender_type !== 'bot') {
            return;
        }

        $botMessage->feedback = $action;
        $botMessage->save();

        if ($action === 'dislike' && $botMessage->ticket) {
            $conversationTicket = $botMessage->ticket;

            $messagesToCopy = $conversationTicket->messages()
                ->orderByDesc('id')
                ->take(6)
                ->get()
                ->reverse();

            $supportTicket = TelegramTicket::create([
                'user_id' => $conversationTicket->user_id,
                'status' => 'open',
            ]);

            $idMap = [];
            foreach ($messagesToCopy as $message) {
                $newMessage = $supportTicket->messages()->create([
                    'sender_id' => $message->sender_id,
                    'sender_type' => $message->sender_type,
                    'message' => $message->message,
                    'reply_to_message_id' => $message->reply_to_message_id ? ($idMap[$message->reply_to_message_id] ?? null) : null,
                    'platform_message_id' => $message->platform_message_id,
                    'platform' => $message->platform,
                    'feedback' => $message->feedback,
                ]);

                $idMap[$message->id] = $newMessage->id;
            }
        }

        $telegram = new TelegramController(config('bale_bot_config.TOKEN'));

        if ($chatId && $msgTelegramId) {
            $telegram->editMessageReplyMarkup([
                'chat_id' => $chatId,
                'message_id' => $msgTelegramId,
                'reply_markup' => json_encode(['inline_keyboard' => []])
            ]);
        }

        if ($chatId) {
            $hasOpenTicket = TelegramTicket::where('user_id', $chatId)
                ->where('status', 'open')
                ->where('is_bot_generated', false)
                ->exists();

            if (!$hasOpenTicket) {
                $telegram->sendMessage([
                    'chat_id' => $chatId,
                    'text' => 'ممنون بابت بازخورد شما 🙏'
                ]);
            }
        }
    }
}
