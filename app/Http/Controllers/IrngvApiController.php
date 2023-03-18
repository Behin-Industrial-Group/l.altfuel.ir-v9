<?php

namespace App\Http\Controllers;

use App\Enums\EnumsEntity;
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
        $this->poll_link = config('irngv')['irngv-poll-link'];
    }

    public function get_token(Request $r)
    {
        return $this->jsonResponse(
            EnumsEntity::irngv_api_msg_code[0], 
            200, 
            [
                "api_token" => UserController::create_api_token(Auth::user())->api_token,
            ],
            0
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
        $msg = "مالک محترم خودروی گازسوز $store->car_name به شماره شاسی $store->chassis ضمن تشکر از مراجعه شما به مرکز خدمات فنی شماره ";
        $msg .= "$store->agency_code ، خواهشمند است با تخصیص زمان ارزشمندتان و شرکت در نظرسنجی ذیل، ما را در ارائه هر چه بهتر خدمات یاری رسانید. لینک نظرسنجی: \n";
        $msg .= config('irngv')['irngv-poll-link'] ."$store->link \n";
        $msg .= "برای ورود به لینک نظرسنجی لازم است فیلترشکن خود را خاموش کنید.\n";
        $msg .= "شماره مرکز تماس اتحادیه کشوری سوخت های جایگزین و خدمات وابسته: 02191013791";
        $sms->send($r->owner_mobile, $msg);
        $store->sms_delivery = 1;
        $store->save();
        return $this->jsonResponse(EnumsEntity::irngv_api_msg_code[0], 200, [], 0);
    }
}
