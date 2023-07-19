<?php

namespace App\Http\Controllers;

use App\Enums\EnumsEntity;
use App\Http\Controllers\Controller;
use App\Models\MobileVerfication;
use Exception;
use Illuminate\Http\Request;

class MobileVerificationController extends Controller
{
    private $sms;
    
    public function __construct() {
        $this->sms = new SMSController();
    }

    public function create_code()
    {
        return rand(1000,9999);
    }

    public function save_code($mobile)
    {
        $mv = MobileVerfication::where('mobile', $mobile);
        if($mv->count())
            return $mv->first()->code;
        $mv = new MobileVerfication();
        $mv->mobile = $mobile;
        $mv->code = $this->create_code();
        $mv->save();
        return $mv->code;
    }

    public function send_code_sms(Request $request)
    {
        $to = $this->check_mobile($request->to);
        if(!$to)
            return 'شماره موبایل نامعتبر';
        $code = $this->save_code($to);
        $msg = 'Code: '. $code . ' کد تایید شماره موبایل شما';
        $send_sms = $this->sms->send($to, $msg);
        if($send_sms !== 'ok')
            return 'پیام ارسال نشد. لطفا مجددا تلاش نمایید';
        return 'ok';
    }

    public function send_newpass_sms(Request $request)
    {
        $to = $this->check_mobile($request->to);
        if(!$to)
            return 'شماره موبایل نامعتبر';
        // $code = $this->save_code($to);
        $msg = "$request->msg
        اتحادیه کشوری سوخت های جایگزین";

        $send_sms = $this->sms->send($to, $msg);
        if($send_sms !== 'ok')
            return 'پیام ارسال نشد. لطفا مجددا تلاش نمایید';
        return 'ok';
    }

    public function send_3month_exp_sms($list)
    {
        $mobiles = [];
        foreach($list as $l){
            $mobile = $this->check_mobile($l);
            if($l)
                $mobiles[] = $mobile;
        }
        $msg = EnumsEntity::_3month_sms_template;
        foreach($mobiles as $mobile){
            $send_sms = $this->sms->send($mobile, $msg);
        }
        
        return true;
    }

    public function check_code($mobile, $code)
    {
        try{
            $m = $this->check_mobile($mobile);
            $mv = MobileVerfication::where('mobile', $m)->first();
            if($mv->code == $code){
                $mv->delete();
                return 'ok';
            }
            return 'err';
        }catch(Exception $e){
            return 'err';
        }
    }

    private function check_mobile($mobile)
    {
        if(strlen($mobile) == 11 and substr($mobile, 0,2) == '98'){
            return $mobile;
        }
        if(strlen($mobile) == 11){
            return '98'. substr($mobile, 1);
        }
        else{
            return false;
        }
    }

}
