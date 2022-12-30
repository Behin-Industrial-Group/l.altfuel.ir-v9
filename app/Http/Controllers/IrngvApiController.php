<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\UserController;
use App\Http\Validations\IrngvUsersInfoValidation;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IrngvApiController extends Controller
{
    use ResponseTrait;

    private $poll_link;

    public function __construct() {
        $this->poll_link = "https://l.altfuel.ir/irngv/poll/";
    }

    public function get_token(Request $r)
    {
        return $this->jsonResponse(
            "توکن با موفقیت ایجاد شد.", 200, 
            [
                "api_token" => UserController::create_api_token(Auth::user())->api_token,
            ]
            );
    }

    public function send_sms(Request $r)
    {
        $v = (new IrngvUsersInfoValidation())->store($r);
        if($v){
            return $v;
        }
        $irngv_user_info = new IrngvUsersInfoController();
        $store = $irngv_user_info->store($r);

        $sms = new SMSController();
        $full_poll_link = $this->poll_link . $store->link;
        $msg = "متقاضی محترم با ورود به لینک زیر و تکمیل فرم نظرسنجی ما را در ارائه بهتر خدمات یاری کنید.\n";
        $msg .= $full_poll_link;
        $sms->send($r->owner_mobile, $msg);
        return $this->jsonResponse("پیامک با موفقیت ارسال شد", 200, [ "poll-link" => $full_poll_link ]);
    }
}
