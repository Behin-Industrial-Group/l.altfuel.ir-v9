<?php

namespace Mkhodroo\AltfuelTicket\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mkhodroo\AltfuelTicket\Models\Ticket;
use Mkhodroo\AltfuelTicket\Models\TicketComment;
use Morilog\Jalali\Jalalian;

class TicketFilterController extends Controller
{
    public function filterByAgent(Request $request)
    {
        $query = Ticket::query();

        if ($request->filled('ticket_number')) {
            $query->where('id', $request->ticket_number);
        }

        if ($request->filled('date')) {
            $date = $this->jalaliToGregorian($request->date);
            $query->whereDate('created_at', $date);
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

        $days_in_jalali_month = [0, 31, 62, 93, 124, 155, 186, 216, 246, 276, 306, 336];

        $jalali_day_no = 365 * $jy + (int)(($jy + 3) / 4) - (int)(($jy + 99) / 100) + (int)(($jy + 399) / 400);
        $jalali_day_no += $days_in_jalali_month[$jm - 1] + $jd;

        if ($jm > 6) {
            $jalali_day_no -= ($jm - 7);
        }

        $g_day_no = $jalali_day_no + 226895;

        $gy = 1600 + 400 * (int)($g_day_no / 146097);
        $g_day_no %= 146097;

        $leap = true;
        if ($g_day_no >= 36525) {
            $g_day_no--;
            $gy += 100 * (int)($g_day_no / 36524);
            $g_day_no %= 36524;

            if ($g_day_no >= 365) {
                $g_day_no++;
            } else {
                $leap = false;
            }
        }

        $gy += 4 * (int)($g_day_no / 1461);
        $g_day_no %= 1461;

        if ($g_day_no >= 366) {
            $leap = false;
            $g_day_no--;
            $gy += (int)($g_day_no / 365);
            $g_day_no %= 365;
        }

        $g_days_in_month = [31, ($leap ? 29 : 28), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
        $gm = 0;
        for (; $gm < 12 && $g_day_no >= $g_days_in_month[$gm]; $gm++) {
            $g_day_no -= $g_days_in_month[$gm];
        }

        $gd = $g_day_no + 1;

        return sprintf('%04d-%02d-%02d', $gy, $gm + 1, $gd);
    }

    function convertPersianNumbers($string)
    {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        return str_replace($persian, $english, $string);
    }

}
