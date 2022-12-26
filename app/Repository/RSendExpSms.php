<?php
namespace App\Repository;

use App\Http\Controllers\MobileVerificationController;
use App\Models\HidroModel;
use App\Models\KamFesharModel;
use App\Models\MarakezModel;
use Illuminate\Http\Request;
use Hekmatinasser\Verta\Facades\Verta;

class RSendExpSms
{
    private $marakezModel;
    private $hidroModel;
    private $kamfesharModel;
    private $MobileVerificationCont;
    private $now;

    public function __construct() {
        $this->marakezModel = new MarakezModel();
        $this->hidroModel = new HidroModel();
        $this->kamfesharModel = new KamFesharModel();
        $this->MobileVerificationCont = new MobileVerificationController();
        $v = verta();
        $this->now = $now = $this->calculate_date($v->year, $v->month, $v->day);
    }

    public function _3months_to_exp_marakez_list(Request $r)
    {
        if($r->getHttpHost() === 'localhost'){
            return -1;
        }
        $list = [];
        $marakez = $this->marakezModel->whereNotNull('ExpDate')->whereNotNull('GuildNumber')->whereNull('SmsSended_3MonthsToExp')->get()->each(function($m){
                        $m = $this->count_exp_date($m);
                    });
        
        $list = $this->edit_3month_sms_sended_date($marakez, $list);

        $marakez = $this->hidroModel->whereNotNull('ExpDate')->whereNotNull('GuildNumber')->whereNull('SmsSended_3MonthsToExp')->get()->each(function($m){
            $m = $this->count_exp_date($m);
        });
        $list = $this->edit_3month_sms_sended_date($marakez, $list);

        $marakez = $this->kamfesharModel->whereNotNull('ExpDate')->whereNotNull('GuildNumber')->whereNull('SmsSended_3MonthsToExp')->get()->each(function($m){
            $m = $this->count_exp_date($m);
        });
        $list = $this->edit_3month_sms_sended_date($marakez, $list);

        $this->MobileVerificationCont->send_3month_exp_sms($list);
        return count($list);
        
    }

    public function calculate_date($year, $month, $day)
    {
        return ((int)$year * 365) + ( ((int)$month -1) * 30 ) + (int)$day;
    }

    public function check_less_than_3month($m)
    {
        $day_to_exp = $m->ExpDate - $this->now; 
        if($day_to_exp <= 90 && $day_to_exp >= 0){
            return true;
        }
        return false;
    }

    private function count_exp_date($m)
    {
        $ExpDate = explode('/',$m->ExpDate);
        if(count($ExpDate) === 3){
            $m->ExpDate = $this->calculate_date($ExpDate[0], $ExpDate[1], $ExpDate[2]);
        }else{
            $ExpDate = explode('-',$m->ExpDate);
            if(count($ExpDate) === 3){
                $m->ExpDate = $this->calculate_date($ExpDate[0], $ExpDate[1], $ExpDate[2]);
            }else{
                $m->ExpDate = $this->now +100;
            }
        }
        return $m;
    }

    private function edit_3month_sms_sended_date($marakez, $list)
    {
        foreach($marakez as $m){
            if($this->check_less_than_3month($m)){
                $list[] = $m->Cellphone;
                $m->refresh();
                $m->SmsSended_3MonthsToExp = verta();
                $m->save();
            }
        }
        return $list;
    }

    public function get_3month_sms_sended_list(Request $r)
    {
        $list = [];
        $marakez = $this->marakezModel->whereNotNull('SmsSended_3MonthsToExp')->get();
        foreach($marakez as $m){
            $list[] = $m;
        }
        $marakez = $this->hidroModel->whereNotNull('SmsSended_3MonthsToExp')->get();
        foreach($marakez as $m){
            $list[] = $m;
        }
        $marakez = $this->kamfesharModel->whereNotNull('SmsSended_3MonthsToExp')->get();
        foreach($marakez as $m){
            $list[] = $m;
        }
        return [
            'data' => $list
        ];
    }
}