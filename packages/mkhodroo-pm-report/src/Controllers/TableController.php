<?php 


namespace Mkhodroo\PMReport\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TableController extends Controller
{
    function get(Request $r){
        $table_name = $r->table_name ? $r->table_name : 'pmt_vacation_requests';
        $url = "/api/v1/table";
        $data = [
            'api_token' => env('PM_REPORT_API_TOKEN'),
            'table_name' => $table_name
        ];

        $results = CurlRequestController::post($url, $data);
        if(isset($results[0])){
            $numberOfCols = 0;
            $colsName = [];
            foreach($results[0] as $key=>$value){
                $numberOfCols++;
                $colsName[] = $key;
            }
            
        }
        return view('PMReportView::index')->with([
            'numberOfCols' => $numberOfCols,
            'colsName' => $colsName,
            'results' => $results
        ]);
    }

    public static function getData(Request $r){
        $url = "/api/v1/table";
        $data = [
            'api_token' => env('PM_REPORT_API_TOKEN'),
            'table_name' => $r->table_name
        ];

        $results = CurlRequestController::post($url, $data);
        if(isset($results[0])){
            $numberOfCols = 0;
            $colsName = [];
            foreach($results[0] as $key=>$value){
                $numberOfCols++;
                $colsName[] = $key;
            }
            return [
                'numberOfCols' => $numberOfCols,
                'colsName' => $colsName,
                'results' => $results
            ];
        }
    }
}