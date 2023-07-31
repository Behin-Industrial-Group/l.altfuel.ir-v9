<?php

namespace Mkhodroo\AltfuelTicket\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        return response()->json([
            'labels' => Ticket::whereBetween('created_at', [Carbon::now(), Carbon::now()->subDays(7)])->select('cat_id')->groupBy('cat_id')->get()->each(function($row){
                $row->catagory = $row->catagory()['name'];
                $row->count = $row->whereCat_id($row->catagory()['id'])->select(DB::raw('count(*) as total'), 'status')->groupBy('status')->get();
            })
        ],200);
    }
}
