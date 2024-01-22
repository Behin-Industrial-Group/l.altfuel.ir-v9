<?php

namespace Mkhodroo\AltfuelTicket\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mkhodroo\AltfuelTicket\Models\Ticket;
use Mkhodroo\AltfuelTicket\Models\TicketCatagory;

class ReportController extends Controller
{
    function numberOfEachCatagory() {
        return [
            'labels' => Ticket::select('cat_id')->groupBy('cat_id')->get()->each(function($row){
                $row->catagory = $row->catagory()['name'];
            })->pluck('catagory'),
            'data' => DB::table('altfuel_tickets')->select(DB::raw('count(*) as total'))->groupBy('cat_id')->pluck('total'),
        ];
    }

    function statusInEachCatagory() {
        $end = Carbon::createFromFormat('Y-m-d', Carbon::now()->subDays(1)->toDateString());
        $start = Carbon::createFromFormat('Y-m-d', Carbon::now()->subDays(8)->toDateString());
        return response()->json([
            'labels' => Ticket::whereBetween('created_at', [$start, $end])->select('cat_id')->groupBy('cat_id')->get()->each(function($row) use( $start, $end){
                $row->catagory = $row->catagory()['name'];
                $row->count = $row->whereBetween('created_at', [$start, $end])->whereCat_id($row->catagory()['id'])->select(DB::raw('count(*) as total'), 'status')->groupBy('status')->get();
            })
        ],200);
    }

    public static function summary(){
        return [
            'number_of_today_tickets' => self::numberOfTodayTickets(),
            'number_of_today_tickets_in_new_status' => self::numberOfTodayTicketsInNewStatus(),
            'number_of_today_tickets_in_answered_status' => self::numberOfTodayTicketsInAnsweredStatus(),
        ];
    }

    public static function numberOfTodayTickets(){
        return Ticket::where('created_at', 'like', '%' . Carbon::today()->toDateString() . '%')->count();
    }

    public static function numberOfTodayTicketsInNewStatus(){
        return Ticket::where('created_at', 'like', '%' . Carbon::today()->toDateString() . '%')
        ->where('status', config('ATConfig.status.new'))->count();
    }

    public static function numberOfTodayTicketsInAnsweredStatus(){
        return Ticket::where('created_at', 'like', '%' . Carbon::today()->toDateString() . '%')
        ->where('status', config('ATConfig.status.answered'))->count();
    }
}
