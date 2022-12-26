<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\RequestTrait;

class WhatsappController extends Controller
{
    public function sendMessage(Request $r)
    {
        $mobile=$r->mobile;
    	$message=$r->message;
    	$data = [
        'phone' => $mobile, // Receivers phone
        'body' => $message, // Message
        ];
        
        $json = json_encode($data);
        
        $url = 'https://eu157.chat-api.com/instance177347/message?token=zouvagkpsqwuwoqb';
        // Make a POST request
        $options = stream_context_create(['http' => [
                'method'  => 'POST',
                'header'  => 'Content-type: application/json',
                'content' => $json
            ]
        ]);
        // Send a request
        $result = file_get_contents($url, false, $options);
        print_r($result);
    }
}
