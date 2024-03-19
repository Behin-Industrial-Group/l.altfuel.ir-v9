<?php 

namespace Mkhodroo\Voip\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mkhodroo\Voip\Models\CallHistory;
use Mkhodroo\Voip\Models\VoipInfo;

class CallHistoryController extends Controller
{
    public static function create(Request $r){
        $ext_num = Auth::user()->ext_num;
        $last_record = CallHistory::where('ext_num', $ext_num)->orderBy('id', 'desc')->first();

        //it's not a new call
        if($last_record->from === $r->from and $last_record->status != config('voip-config.call-status.answered')){
            return $last_record;
        }

        //it's a new call
        return CallHistory::create([
            'ext_num' => Auth::user()->ext_num,
            'from' => $r->from,
            'status' => $r->status
        ]);
    }

    public static function update(Request $r){
        CallHistory::where('id', $r->id)->update($r->all());
    }
}