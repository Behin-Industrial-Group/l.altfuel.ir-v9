<?php 


namespace Mkhodroo\PMReport\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VacationController extends Controller
{
    function getNumberOfVacation(Request $r){
        $url = "/api/v1/user/get-by-username";
        $data = [
            'api_token' => env('PM_REPORT_API_TOKEN'),
            'username' => Auth::user()->pm_username
        ];
        $user = CurlRequestController::post($url, $data);

        $url = "/api/v1/table";
        $data = [
            'api_token' => env('PM_REPORT_API_TOKEN'),
            'table_name' => 'pmt_vacation_requests'
        ];

        $results = collect(CurlRequestController::post($url, $data));
        $result = $results->where('USER_ID', $user->USR_UID);
        
        $hourly = 0;
        $daily = 0;
        foreach($result as $result){
            if($result->TYPE === 'hourly')
                $hourly += (float)$result->DURATION; 
            if($result->TYPE === 'daily')
                $daily += (float)$result->DURATION;
        }
        return [
            'daily' => $daily,
            'hourly' => $hourly,
        ];
    }

    
}