<?php

namespace Mkhodroo\AltfuelTicket\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Mkhodroo\AltfuelTicket\Models\TicketComment;
use stdClass;

class LangflowController extends Controller
{
    public static function ticketLastCommentReply(Request $request)
    {
        $lastComment = TicketComment::where('ticket_id', $request->ticket_id)->orderBy('id', 'desc')->first();
        $question = $lastComment->text;
        $reply = self::run($question);
        return response()->json(['message' => $reply]);
    }

    public static function run($question)
    {

        $curl = curl_init();

        $data = [
            "input_value" => $question,
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
            CURLOPT_URL => 'https://api.langflow.astra.datastax.com/lf/' . env('LANGFLOW_PROJECT_ID') . '/api/v1/run/' . env('LANGFLOW_FLOW_ID') . '?stream=false',
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
                'Authorization: Bearer ' . env('APPLICATION_TOKEN')
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        $decodedResponse = json_decode($response, true);

        $reply = $decodedResponse['outputs'][0]['outputs'][0]['results']['message']['text'];

        return $reply;
    }
}
