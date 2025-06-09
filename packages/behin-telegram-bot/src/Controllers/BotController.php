<?php

namespace TelegramBot\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mkhodroo\AltfuelTicket\Controllers\LangflowController;
use TelegramBot\Models\TelegramUser;

class BotController extends Controller
{
    public function chat()
    {

        Log::info("Receive Message");
        $content = file_get_contents('php://input');
        $update = json_decode($content, true);
        if (isset($update['callback_query'])) {
            return $this->handleCallback($update);
        }
        $telegram = new TelegramController(config('telegram_bot_config.TOKEN'));

        $message = $update['message'] ?? null;
        $chat_id = $message['chat']['id'] ?? null;
        $text = $message['text'] ?? null;
        $contact = $message['contact'] ?? null;
        $telegramMessageId = $message['message_id'] ?? null; // ✅ اضافه شد

        if (!$chat_id || !$telegramMessageId) return;

        // ✅ چک کن که آیا قبلاً این پیام پردازش شده یا نه
        $alreadyProcessed = DB::table('telegram_messages')
            ->where('telegram_message_id', $telegramMessageId)
            ->where('user_id', $chat_id)
            ->exists();

        if ($alreadyProcessed) {
            Log::info("Duplicate message ignored: $telegramMessageId");
            return;
        }

        $user = TelegramUser::firstOrCreate(['chat_id' => $chat_id]);

        // گرفتن نام کاربر
        if (!$user->name) {
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

            $telegram->sendMessage([
                'chat_id' => $chat_id,
                'text' => "سلام! من صفا هستم 🤖\nدستیار هوش مصنوعی شما در تلگرام.\nبرای شروع لطفاً نام خود را وارد کن."
            ]);
            return;
        }

        // گرفتن شماره تلفن
        if (!$user->phone) {
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



        if ($text === '/start') {
            $telegram->sendMessage([
                'chat_id' => $chat_id,
                'text' => "سلام {$user->name} ! من صفا هستم 🤖\nدستیار هوش مصنوعی شما در تلگرام.\nسوالت رو بپرس"
            ]);
            return;
        }

        // پردازش سوال کاربر
        if ($text && $text !== '/start') {
            // ارسال پیام "⏳ در حال پردازش..."
            $loadingMessage = $telegram->sendMessage([
                'chat_id' => $chat_id,
                'text' => "⏳ در حال پردازش..."
            ]);
            $loadingMessageId = json_decode($loadingMessage, true)['result']['message_id'] ?? null;

            try {
                // اجرای Langflow
                $botResponse = LangflowController::run($text, $chat_id);

                // حذف پیام لودینگ
                if ($loadingMessageId) {
                    $telegram->deleteMessage([
                        'chat_id' => $chat_id,
                        'message_id' => $loadingMessageId
                    ]);
                }

                // ذخیره در پایگاه داده
                $messageId = DB::table('telegram_messages')->insertGetId([
                    'user_id' => $chat_id,
                    'user_message' => $text,
                    'bot_response' => $botResponse,
                    'feedback' => 'none',
                    'telegram_message_id' => $telegramMessageId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // دکمه‌های لایک/دیس‌لایک
                $keyboard = [
                    'inline_keyboard' => [
                        [
                            ['text' => '👍', 'callback_data' => "like:$messageId"],
                            ['text' => '👎', 'callback_data' => "dislike:$messageId"],
                        ]
                    ]
                ];

                // ارسال پاسخ نهایی
                $response = $telegram->sendMessage([
                    'chat_id' => $chat_id,
                    'text' => $botResponse . "\n\nآیا این پاسخ مفید بود؟",
                    'reply_markup' => json_encode($keyboard)
                ]);

                // ذخیره آیدی پیام ربات
                $responseData = json_decode($response, true);
                $msgTelegramId = $responseData['result']['message_id'] ?? null;

                DB::table('telegram_messages')->where('id', $messageId)->update([
                    'telegram_message_id' => $msgTelegramId
                ]);
            } catch (\Exception $e) {
                Log::error("Langflow Error: " . $e->getMessage());

                // حذف پیام لودینگ در صورت خطا
                if ($loadingMessageId) {
                    $telegram->deleteMessage([
                        'chat_id' => $chat_id,
                        'message_id' => $loadingMessageId
                    ]);
                }

                // پیام خطا
                $telegram->sendMessage([
                    'chat_id' => $chat_id,
                    'text' => "❌ متأسفم، مشکلی پیش اومده. لطفاً دوباره امتحان کن."
                ]);
            }

            return;
        }
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

            DB::table('telegram_messages')->where('id', $msgId)->update([
                'feedback' => $action,
                'updated_at' => now()
            ]);

            $telegram = new TelegramController(config('telegram_bot_config.TOKEN'));

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
