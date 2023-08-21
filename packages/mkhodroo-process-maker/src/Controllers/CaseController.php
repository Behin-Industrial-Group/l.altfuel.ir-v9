<?php 

namespace Mkhodroo\MkhodrooProcessMaker\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use SoapClient;

class CaseController extends Controller
{
    private $newPass, $accessToken, $userId;
    public function __construct() {
        $this->newPass = rand(10000000,99999999 );
        Log::info($this->newPass);
        $this->accessToken = PMController::getAccessToken();
        
    }
    function get() {
        Log::info("access token:");
        Log::info($this->accessToken);
        $this->userId = PMController::getUserId($this->accessToken);
        Log::info("user id: ");
        Log::info($this->userId);
        PMController::changePass($this->accessToken, $this->userId, $this->newPass);
        $pm_username = Auth::user()->pm_username;
        return view('test')->with([
            'src' => env('PM_SERVER') ."/sysworkflow/fa/neoclassic/login/login?user=$pm_username&pass=$this->newPass&u=%2Fsysworkflow%2Ffa%2Fneoclassic%2Fcases%2Fviena_init#/casesListExtJs?action=todo",
            'user' => Auth::user()->pm_username,
            'pass' => $this->newPass
        ]);
    }

    function newCase() {
        $this->userId = PMController::getUserId($this->accessToken);
        PMController::changePass($this->accessToken, $this->userId, $this->newPass);
        $newCaseUrl = "/sysworkflow/fa/neoclassic/login/login?u=%2Fsysworkflow%2Fen%2Fneoclassic%2Fcases%2FcasesStartPage%3Faction%3DstartCase";
        return view('test')->with([
            'src' => env('PM_SERVER') . $newCaseUrl . "&user=". Auth::user()->pm_username ."&pass=$this->newPass",
            'user' => Auth::user()->pm_username,
            'pass' => $this->newPass
        ]);
    }
}

