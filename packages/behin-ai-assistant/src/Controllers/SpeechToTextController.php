<?php

namespace AiAssistant\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SpeechToTextController extends Controller
{
    public static function sendSpeech(Request $request)
    {
        $url = $request->speech;
        $language = 'none'; // if none, text not translated. else can use fa, ar, en to translate.

        $data = [
            'url' => $url,
            'language' => $language
        ];

        $data_string = json_encode($data);

        $ch = curl_init('https://api.talkbot.ir/v1/media/speech-to-text/REQ');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer 11',
            'Content-Length: ' . strlen($data_string)
        ]);

        $result = curl_exec($ch);

        curl_close($ch);

        return $result;
    }
}
