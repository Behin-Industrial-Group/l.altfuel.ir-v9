<?php

namespace Mkhodroo\Voip\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mkhodroo\Voip\Models\AsteriskCdr;

class VoipController extends Controller
{
    public static $dstMapToExpert = [
        '102' => 'بابایی',
        '103' => 'سیدی',
        '105' => 'شهاب',
        '108' => 'گل گواهی',
        '115' => 'شهریاری',
        '116' => 'شهیدی',
        '120' => 'احمدی',
        '122' => 'شادمان',
        '123' => 'حاجیوند',
        '125' => 'آهنگران',
    ];

    public static function get_voip_poll_info()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://voip.altfuel.ir/mkhodroo.php?api_token=A8k228dD4nOWXrclp2u9ubFT9Yt2xfJL');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, False);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, False);
        $er = curl_error($ch);
        $result = curl_exec($ch);
        curl_close($ch);

        $data = collect(unserialize($result));
        return [
            '1000' => ['queue_num' => '1000', 'name' => 'اپراتور', 'score_avg' => $data->where('queue_num', '1000')->avg('score'), 'count' => $data->where('queue_num', '1000')->count()],
            '1001' => ['queue_num' => '1001', 'name' => 'متقاضیان irngv', 'score_avg' => $data->where('queue_num', '1001')->avg('score'), 'count' => $data->where('queue_num', '1001')->count()],
            '1002' => ['queue_num' => '1002', 'name' => 'مراکز irngv', 'score_avg' => $data->where('queue_num', '1002')->avg('score'), 'count' => $data->where('queue_num', '1002')->count()],
            '1003' => ['queue_num' => '1003', 'name' => 'تخصیص بازرس به مرکز', 'score_avg' => $data->where('queue_num', '1003')->avg('score'), 'count' => $data->where('queue_num', '1003')->count()],
            '1004' => ['queue_num' => '1004', 'name' => 'تخصیص هیدرو به مرکز', 'score_avg' => $data->where('queue_num', '1004')->avg('score'), 'count' => $data->where('queue_num', '1004')->count()],
            '2001' => ['queue_num' => '2001', 'name' => 'پذیرش اولیه', 'score_avg' => $data->where('queue_num', '2001')->avg('score'), 'count' => $data->where('queue_num', '2001')->count()],
            '2002' => ['queue_num' => '2002', 'name' => 'آموزش', 'score_avg' => $data->where('queue_num', '2002')->avg('score'), 'count' => $data->where('queue_num', '2002')->count()],
            '2003' => ['queue_num' => '2003', 'name' => 'بازرسی', 'score_avg' => $data->where('queue_num', '2003')->avg('score'), 'count' => $data->where('queue_num', '2003')->count()],
            '2004' => ['queue_num' => '2004', 'name' => 'احکام و مالیات', 'score_avg' => $data->where('queue_num', '2004')->avg('score'), 'count' => $data->where('queue_num', '2004')->count()],
            '2005' => ['queue_num' => '2005', 'name' => 'مالی پروانه کسب', 'score_avg' => $data->where('queue_num', '2005')->avg('score'), 'count' => $data->where('queue_num', '2005')->count()],
            '3000' => ['queue_num' => '3000', 'name' => 'شکایات و بازرسی', 'score_avg' => $data->where('queue_num', '3000')->avg('score'), 'count' => $data->where('queue_num', '3000')->count()],
            '4000' => ['queue_num' => '4000', 'name' => 'دبیرخانه', 'score_avg' => $data->where('queue_num', '4000')->avg('score'), 'count' => $data->where('queue_num', '4000')->count()],
            '5000' => ['queue_num' => '5000', 'name' => 'مدیریت', 'score_avg' => $data->where('queue_num', '5000')->avg('score'), 'count' => $data->where('queue_num', '5000')->count()],
            '6000' => ['queue_num' => '6000', 'name' => 'مالی', 'score_avg' => $data->where('queue_num', '6000')->avg('score'), 'count' => $data->where('queue_num', '6000')->count()],
            '7000' => ['queue_num' => '7000', 'name' => '2001', 'score_avg' => $data->where('queue_num', '7000')->avg('score'), 'count' => $data->where('queue_num', '7000')->count()],
            '8000' => ['queue_num' => '8000', 'name' => 'ال پی جی ', 'score_avg' => $data->where('queue_num', '8000')->avg('score'), 'count' => $data->where('queue_num', '8000')->count()],
            '9000' => ['queue_num' => '9000', 'name' => 'تستی', 'score_avg' => $data->where('queue_num', '9000')->avg('score'), 'count' => $data->where('queue_num', '9000')->count()],
            'total' => ['queue_num' => 'all', 'name' => 'میانگین کل', 'score_avg' => $data->where('queue_num', '!=', '8000')->avg('score'), 'count' => $data->where('queue_num', '!=', '8000')->count()],
        ];
    }

    public static function getPeerPollInfo($queue_num = 'all')
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://voip.altfuel.ir/mkhodroo.php?queue_num=$queue_num&api_token=A8k228dD4nOWXrclp2u9ubFT9Yt2xfJL");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, False);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, False);
        $er = curl_error($ch);
        $result = curl_exec($ch);
        curl_close($ch);

        return view('VoipViews::poll-details')->with([
            'data' => unserialize($result)
        ]);
    }

    public static function getCallReport(Request $request)
    {

        $startDate = $request->start_date ? $request->start_date : Carbon::yesterday(); // تاریخ شروع
        $endDate = $request->end_date ? $request->end_date : Carbon::today(); // تاریخ پایان

        $data = AsteriskCdr::select(
            'dst',
            DB::raw('COUNT(DISTINCT src) as unique_dst_count'),
            DB::raw("COUNT(DISTINCT CASE WHEN disposition = 'ANSWERED' THEN src END) as answered_calls"),
            DB::raw("COUNT(DISTINCT CASE WHEN disposition = 'NO ANSWER' THEN src END) as no_answered_calls"),
            DB::raw("COUNT(DISTINCT CASE WHEN disposition = 'BUSY' THEN src END) as busy_calls"),
        )
            ->whereIn('dst', ['102', '103', '105', '108', '115', '116', '117', '120', '122', '123', '125'])
            ->whereBetween('calldate', [$startDate, $endDate])
            ->groupBy('dst')
            ->get();
        return view('VoipViews::call-report')->with([
            'callStats' => $data,
            'dstMapToExpert' => self::$dstMapToExpert
        ]);
    }

    public static function getCallReportByDate($date = null)
    {
        $date = $date ? $date : date('Y-m-d');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://voip.altfuel.ir/mkhodroo_pbxapi/cdr-report-by-date.php?date=$date&api_token=A8k228dD4nOWXrclp2u9ubFT9Yt2xfJL");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, False);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, False);
        $er = curl_error($ch);
        $result = curl_exec($ch);
        curl_close($ch);
        return view('VoipViews::call-report-by-date')->with([
            'data' => unserialize($result)
        ]);
    }


    public static function sip_show_peers_status()
    {
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
        foreach ($data as $onlineUser) {
            if (in_array("OK", $onlineUser)) {
                print_r($onlineUser);
                FirstOnlineTimeController::set($onlineUser[0]);
            }
        }
        // return $data->where('71', 'OK');
        // return $data;
    }

    function dlVoice(Request $r)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $r->link);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, False);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, False);
        $er = curl_error($ch);
        $result = curl_exec($ch);
        return $result != "404" ? $r->link : $result;
    }

    function recordedList()
    {
        $date = date('Y-m-d');
        $url = "https://voip.altfuel.ir/mkhodroo_pbxapi/all-voice.php?date=$date";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, False);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, False);
        $result = curl_exec($ch);
        $result = unserialize($result);

        return view('VoipViews::recorded-list')->with(
            ['result' => $result]
        );
    }

    function softphone()
    {
        return view('VoipViews::softphone');
    }
}
