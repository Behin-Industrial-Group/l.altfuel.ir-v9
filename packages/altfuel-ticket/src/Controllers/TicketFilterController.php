<?php

namespace Mkhodroo\AltfuelTicket\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use IntlDateFormatter;
use Mkhodroo\AltfuelTicket\Models\Ticket;
use Mkhodroo\AltfuelTicket\Models\TicketComment;

class TicketFilterController extends Controller
{
    public function filterByAgent(Request $request)
    {
        $query = Ticket::query();

        if ($request->filled('ticket_number')) {
            $query->where('id', $request->ticket_number);
        }

        if ($request->filled('date_from')) {
            $from = $this->jalaliToGregorian($request->date_from);
            $query->where('created_at', '>=', $from);
        }

        if ($request->filled('date_to')) {
            $to = $this->jalaliToGregorian($request->date_to);
            $query->where('created_at', '<=', $to);
        }

        if ($request->filled('agent_id')) {
            $ticketIds = TicketComment::where('user_id', $request->agent_id)->pluck('ticket_id')->unique();
            $query->whereIn('id', $ticketIds);
        }

        $result = $query->get()->each(function ($row) {
            $row->catagory = $row->catagory()['name'] ?? '-';
            $row->user = $row->user()?->display_name ?? '-';
            $row->actor = $row->actor()?->display_name ?? '-';
            // $row->user_level = $row->user()->level(); // فعال‌سازی در صورت نیاز
        });

        return response()->json($result);
    }

    function jalaliToGregorian($jalaliDate)
    {
        [$jy, $jm, $jd] = explode('/', $this->convertPersianNumbers($jalaliDate));
        $jy = (int)$jy;
        $jm = (int)$jm;
        $jd = (int)$jd;

        $gy = $jy + 621;

        $leapJ = $this->isJalaliLeap($jy);
        $march = ($leapJ) ? 20 : 21;

        $jalaliDays = $this->jalaliDayOfYear($jm, $jd, $leapJ);

        $gDate = mktime(0, 0, 0, 3, $march, $gy); // 1 Farvardin = March 20 or 21
        $gDate += ($jalaliDays - 1) * 86400;

        return date('Y-m-d', $gDate);
    }

    function jalaliDayOfYear($month, $day, $isLeap)
    {
        $daysInMonth = [0, 31, 62, 93, 124, 155, 186, 216, 246, 276, 306, 336];
        return $daysInMonth[$month - 1] + $day;
    }

    function isJalaliLeap($year)
    {
        $mod = $year % 33;
        return in_array($mod, [1, 5, 9, 13, 17, 22, 26, 30]);
    }

    function convertPersianNumbers($string)
    {
        $persian = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
        $english = ['0','1','2','3','4','5','6','7','8','9'];
        return str_replace($persian, $english, $string);
    }

}
