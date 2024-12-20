<?php 

namespace Mkhodroo\Voip\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Mkhodroo\Voip\Models\VoipInfo;

class FirstOnlineTimeController extends Controller
{
    public static function set($user_id){
        $key = 'first-online-time';
        $value = Carbon::now();
        $data = VoipInfo::where('user_id', $user_id)->where('key', $key)->whereDate('created_at', Carbon::today())->first();
        if($data){
            $key = 'online-time';
        }
        return VoipInfo::create([
            'user_id' => $user_id,
            'key' => $key,
            'value' => $value
        ]);
    }

    public static function avg(){
        $rows = VoipInfo::get()->each(function($row){
            $row->time = explode(" ", $row->value)[1];
            $row->time = explode(":", $row->time);
            $row->time = $row->time[0] + $row->time[1] / 60;
        });
        $data = explode(".", $rows->avg('time'));
        return $data[0] . ':' . str_limit($data[1] *60, 2, '') ;

    }
}