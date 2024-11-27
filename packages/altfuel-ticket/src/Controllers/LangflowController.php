<?php

namespace Mkhodroo\AltfuelTicket\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Mkhodroo\AltfuelTicket\Models\TicketComment;
use stdClass;

class LangflowController extends Controller
{
    public static function run()
    {
        // $lastComment = TicketComment::where('ticket_id', $request->ticket_id)->orderBy('id', 'desc')->first();
        // return response()->json(['message' => $lastComment->text]);


        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . 'AstraCS:NefmcszgGgzjPsmBbyUGaSra:6a543b5db7f883861cee2b0926451700b5d973b21d06127cea6fe25e223e6c3f',
        ])->post('https://api.langflow.astra.datastax.com/lf/f52522a6-cf86-4c2b-867b-b619da53ddee/api/v1/run/f1540628-e150-4805-be8a-59111e1852c1?stream=false', [
            'input_value' => 'من چند ساله هستم؟',
            'output_type' => 'chat',
            'input_type' => 'chat',
            'tweaks' => [
                'ChatInput-S6pVj' => [],
                'ParseData-RKLei' => [],
                'Prompt-ipfvP' => [],
                'SplitText-9KAvp' => [],
                'ChatOutput-dUVEn' => [],
                'AstraDB-y5TS6' => [],
                'AstraDB-LYPfX' => [],
                'File-q7DuD' => [],
                'GroqModel-LutP7' => [],
                'CohereEmbeddings-jUybi' => [],
                'CohereEmbeddings-2MzXP' => [],
            ],
        ]);

        return $response->json();
    }

    public static function run2()
    {

        $curl = curl_init();

        // داده‌های JSON به عنوان آرایه PHP
        $data = [
            "input_value" => "hello",
            "output_type" => "chat",
            "input_type" => "chat",
            "tweaks" => [
                "Agent-lCMES" => new stdClass(),
                "ChatInput-sr1BR" => new stdClass(),
                "ChatOutput-YRLDS" => new stdClass(),
                "URL-SP0nv" => new stdClass(),
                "CalculatorTool-v4RbN" => new stdClass()
            ]
        ];

        // مقداردهی تنظیمات cURL
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.langflow.astra.datastax.com/lf/13e73b34-94df-445b-a1ad-60ad9e0a0087/api/v1/run/8e085f9d-3d5a-46ab-bb19-0c17a6adbbd8?stream=false',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($data), // داده‌های JSON به‌درستی اینجا رمزگذاری می‌شوند
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer AstraCS:APxfrRDFpEeZQUjRsbQhufgM:bb0f87f52dfdbb5d7e9dbf0c87b4919adb7a1610cba4fc808ede0716e4f5e704'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        // نمایش پاسخ
        echo $response;
    }
}
