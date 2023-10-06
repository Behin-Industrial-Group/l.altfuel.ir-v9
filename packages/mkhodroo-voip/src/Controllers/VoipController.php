<?php

namespace Mkhodroo\Voip\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VoipController extends Controller
{
    public static function get_voip_poll_info()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://voip.altfuel.ir/mkhodroo.php');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, False);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, False);
        $er = curl_error($ch);
        $result = curl_exec($ch);
        curl_close($ch);

        $data = collect(unserialize($result));
        return [
            '1000' => ['name' => 'اپراتور', 'score_avg' => $data->where('queue_num', '1000')->avg('score'), 'count' => $data->where('queue_num', '1000')->count()],
            '1001' => ['name' => 'متقاضیان irngv', 'score_avg' => $data->where('queue_num', '1001')->avg('score'), 'count' => $data->where('queue_num', '1001')->count()],
            '1002' => ['name' => 'مراکز irngv', 'score_avg' => $data->where('queue_num', '1002')->avg('score'), 'count' => $data->where('queue_num', '1002')->count()],
            '1003' => ['name' => 'تخصیص بازرس به مرکز', 'score_avg' => $data->where('queue_num', '1003')->avg('score'), 'count' => $data->where('queue_num', '1003')->count()],
            '1004' => ['name' => 'تخصیص هیدرو به مرکز', 'score_avg' => $data->where('queue_num', '1004')->avg('score'), 'count' => $data->where('queue_num', '1004')->count()],
            '2001' => ['name' => 'پذیرش اولیه', 'score_avg' => $data->where('queue_num', '2001')->avg('score'), 'count' => $data->where('queue_num', '2001')->count()],
            '2002' => ['name' => 'آموزش', 'score_avg' => $data->where('queue_num', '2002')->avg('score'), 'count' => $data->where('queue_num', '2002')->count()],
            '2003' => ['name' => 'بازرسی', 'score_avg' => $data->where('queue_num', '2003')->avg('score'), 'count' => $data->where('queue_num', '2003')->count()],
            '2004' => ['name' => 'احکام و مالیات', 'score_avg' => $data->where('queue_num', '2004')->avg('score'), 'count' => $data->where('queue_num', '2004')->count()],
            '2005' => ['name' => 'مالی پروانه کسب', 'score_avg' => $data->where('queue_num', '2005')->avg('score'), 'count' => $data->where('queue_num', '2005')->count()],
            '3000' => ['name' => 'شکایات و بازرسی', 'score_avg' => $data->where('queue_num', '3000')->avg('score'), 'count' => $data->where('queue_num', '3000')->count()],
            '4000' => ['name' => 'دبیرخانه', 'score_avg' => $data->where('queue_num', '4000')->avg('score'), 'count' => $data->where('queue_num', '4000')->count()],
            '5000' => ['name' => 'مدیریت', 'score_avg' => $data->where('queue_num', '5000')->avg('score'), 'count' => $data->where('queue_num', '5000')->count()],
            '6000' => ['name' => 'مالی', 'score_avg' => $data->where('queue_num', '6000')->avg('score'), 'count' => $data->where('queue_num', '6000')->count()],
            '7000' => ['name' => '2001', 'score_avg' => $data->where('queue_num', '7000')->avg('score'), 'count' => $data->where('queue_num', '7000')->count()],
            '8000' => ['name' => 'ال پی جی ', 'score_avg' => $data->where('queue_num', '8000')->avg('score'), 'count' => $data->where('queue_num', '8000')->count()],
            '9000' => ['name' => 'تستی', 'score_avg' => $data->where('queue_num', '9000')->avg('score'), 'count' => $data->where('queue_num', '9000')->count()],

        ];
    }

    public static function sip_show_peers_status(){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://voip.altfuel.ir/mkhodroo_pbxapi/sip-show-peers.php');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, False);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, False);
        $er = curl_error($ch);
        $result = curl_exec($ch);
        curl_close($ch);
        $data = collect(unserialize($result));
        // print_r($data);
        // $onlineUsers = $data->where('71', 'OK');
        foreach($data as $onlineUser){
            if(in_array("OK", $onlineUser)){
                print_r($onlineUser);
                FirstOnlineTimeController::set($onlineUser[0]);
            }
        }
        // return $data->where('71', 'OK');
        // return $data;
    }
}
