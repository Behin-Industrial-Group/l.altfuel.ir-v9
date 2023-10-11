<?php

namespace Mkhodroo\SmsTemplate\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SMSController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SmsTemplateController extends Controller
{
    public static function getViewById($sms_id){
        switch($sms_id){
            case "123456";
                return view('SmsTempView::test');
                break;
        }
    }

    public static function send(Request $r, $sms_id, $to, $params = null, SendSmsController $sms ) {
        $body = self::getViewById($sms_id); 
        if(!$body){
            return response("no view founded",400);
        }
        $params = $params ? unserialize($params): null ;
        $body = $body->with(['params' => $params])->render();  
        $sms->send($to, $body);
        
    }
}
