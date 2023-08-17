<?php 

namespace Mkhodroo\MkhodrooProcessMaker\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use SoapClient;

class CaseController extends Controller
{
    private $newPass, $accessToken, $userId;
    public function __construct() {
        $this->newPass = rand(10000000,99999999 );
        $this->accessToken = PMController::getAccessToken();
        
    }
    function get() {
        $this->userId = PMController::getUserId($this->accessToken);
        PMController::changePass($this->accessToken, $this->userId, $this->newPass);
        return view('test')->with([
            'src' => env('PM_SERVER') ."/sysworkflow/fa/neoclassic/login/login?u=%2Fsysworkflow%2Fen%2Fneoclassic%2Fcases%2FcasesListExtJs&user=". Auth::user()->pm_username ."&pass=$this->newPass",
            'user' => Auth::user()->pm_username,
            'pass' => $this->newPass
        ]);
    }

    function newCase() {
        $this->userId = PMController::getUserId($this->accessToken);
        PMController::changePass($this->accessToken, $this->userId, $this->newPass);
        $newCaseUrl = env('PM_SERVER') ."/sysworkflow/fa/neoclassic/login/login?u=%2Fsysworkflow%2Fen%2Fneoclassic%2Fcases%2FcasesStartPage%3Faction%3DstartCase";
        return view('test')->with([
            'src' => env('PM_SERVER') . $newCaseUrl . "&user=". Auth::user()->pm_username ."&pass=$this->newPass",
            'user' => Auth::user()->pm_username,
            'pass' => $this->newPass
        ]);
    }
}

