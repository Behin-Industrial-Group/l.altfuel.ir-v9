<?php

namespace IsoAgent\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LangflowIsoController extends Controller
{

    public static function run($question)
    {

        // $curl = curl_init();

        // $data = [
        //     "input_value" => $question,
        //     "output_type" => "chat",
        //     "input_type" => "chat",
        //     "tweaks" => [
        //         "Agent-lCMES" => new \stdClass(),
        //         "ChatInput-sr1BR" => new \stdClass(),
        //         "ChatOutput-YRLDS" => new \stdClass(),
        //         "URL-SP0nv" => new \stdClass(),
        //         "CalculatorTool-v4RbN" => new \stdClass()
        //     ]
        // ];

        // مقداردهی تنظیمات cURL
        // curl_setopt_array($curl, array(
        //     CURLOPT_URL => 'https://api.langflow.astra.datastax.com/lf/' . env('ISO_LANGFLOW_PROJECT_ID') . '/api/v1/run/' . env('ISO_LANGFLOW_FLOW_ID') . '?stream=false',
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => '',
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 0,
        //     CURLOPT_FOLLOWLOCATION => true,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => 'POST',
        //     CURLOPT_POSTFIELDS => json_encode($data), // داده‌های JSON به‌درستی اینجا رمزگذاری می‌شوند
        //     CURLOPT_HTTPHEADER => array(
        //         'Content-Type: application/json',
        //         'Authorization: Bearer ' . env('ISO_APPLICATION_TOKEN')
        //     ),
        // ));

        $url = "https://api.langflow.astra.datastax.com/lf/968a6eb1-8a37-4f86-bf13-8179e02d24d6/api/v1/run/b9c3d565-3b4b-4a96-9637-b2d14e217eed?stream=false";

        $payload = [
            "input_value" => $question,
            "output_type" => "chat",
            "input_type" => "chat",
            "tweaks" => [
                "SplitText-8DSoR" => new \stdClass(),
                "File-ifFIF" => new \stdClass(),
                "CohereEmbeddings-yyCRo" => new \stdClass(),
                "Chroma-ehU8j" => new \stdClass(),
                "Chroma-ny1Le" => new \stdClass(),
                "Agent-MQZkc" => new \stdClass(),
                "RetrieverTool-7pSyi" => new \stdClass(),
                "CohereEmbeddings-xbZH9" => new \stdClass(),
                "ChatInput-8K4z7" => new \stdClass(),
                "ChatOutput-615mb" => new \stdClass(),
                "GroqModel-pS23q" => new \stdClass()
            ]
        ];

        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer '. env('ISO_APPLICATION_TOKEN')
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }

        curl_close($ch);
        $decodedResponse = json_decode($response, true);
        $reply = $decodedResponse['outputs'][0]['outputs'][0]['results']['message']['text'];
        return $reply;


        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        
        return $decodedResponse;

        

        return $reply;
    }
}
