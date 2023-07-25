<?php

namespace Mkhodroo\AltfuelTicket\Controllers;

use App\Http\Controllers\Controller;
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
}
