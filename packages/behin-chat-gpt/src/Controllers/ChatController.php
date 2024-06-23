<?php

namespace ChatGpt\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Throwable;

class ChatController extends Controller
{
    /**
     * @param Request $request
     * @return string
     */
    public function __invoke(Request $request): string
    {
        try {
            /** @var array $response */
            $response = Http::withHeaders([
                "Content-Type" => "application/json",
                "Authorization" => "Bearer " . config('behin_gpt_config.API_KEY')
            ])->post('https://api.openai.com/v1/chat/completions', [
                "model" => $request->post('model'),
                "messages" => [
                    [
                        "role" => "user",
                        "content" => $request->post('content')
                    ]
                ],
                "temperature" => 0,
                "max_tokens" => 2048
            ])->body();
            $response = json_decode($response);
            return $response->choices[0]->message->content;
        } catch (Throwable $e) {
            return $e->getMessage();
            return "Chat GPT Limit Reached. This means too many people have used this demo this month and hit the FREE limit available. You will need to wait, sorry about that.";
        }
    }
}

