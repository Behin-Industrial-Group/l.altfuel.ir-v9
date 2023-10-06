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
            return null;
        }
        return VoipInfo::create([
            'user_id' => $user_id,
            'key' => $key,
            'value' => $value
        ]);
    }
}