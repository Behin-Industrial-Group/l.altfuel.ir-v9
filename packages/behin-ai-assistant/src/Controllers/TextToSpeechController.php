<?php

namespace AiAssistant\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TextToSpeechController extends Controller
{

    public static function sendText(Request $request)
    {
        $headers = [
            'Authorization: Bearer sk-6f0e36f5a114379e3cf2fb6c8b6c8c3a'
        ];
        $data = [
            'text' => "سلام شما با اتحادیه کشوری سوخت های جایگزین تماس گرفته اید",
            'gender' => 'female',
            'lang' => 'persian'
        ];
        $url = 'https://api.talkbot.ir/v1/media/text-to-speech/REQ';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        if(curl_errno($ch)){
            echo 'error CURL: ' . curl_error($ch);
            return ;
        }
        curl_close($ch);
        return $response;

    }

}

