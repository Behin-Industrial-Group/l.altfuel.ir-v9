<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SMSController extends Controller
{
    private $url;
    private $user;
    private $pass;
    private $org;

    public function __construct() {
        $this->url = 'https://new.payamsms.com/services/rest/index.php';
        $this->org = 'irngv';
        $this->user = 'irngv';
        $this->pass = 'irngv123';
    }
    public function send($to, $msg)
    {
        $data = array(
            'organization' => $this->org,
            'username' => $this->user,
            'password' => $this->pass,
            'method' => 'send',
            'messages' => array([
                'sender' => '9820003807',
                'recipient' => $to,
                'body' => $msg,
                'customerId' => 1,
            ]
            )
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        # Setup request to send json via GET.
        $payload = json_encode($data);
        
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, True);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, True);
    
        # Return response instead of printing.
        # Send request.
        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result);
        if(isset($result->data[0]->serverId))
            return 'ok';
        return $result;
    }

}
