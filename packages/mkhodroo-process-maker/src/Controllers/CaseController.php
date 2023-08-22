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
        if(!$this->accessToken){
            return view('test')->with([
                'error' => 'خطا در دریافت access token'
            ]);
        }
        $this->userId = PMController::getUserId($this->accessToken);
        if(!$this->userId){
            $createUser = PMController::createUser($this->accessToken, Auth::user());
            if(!$createUser){
                return view('test')->with([
                    'error' => 'کاربر process maker وجود ندارد. خطا در ایجاد کاربر' 
                ]);
            }
            return view('test')->with([
                'error' => 'خطا در دریافت نام کاربر'
            ]);
        }
        if(!PMController::changePass($this->accessToken, $this->userId, $this->newPass)){
            return view('test')->with([
                'error' => 'خطا در تغییر رمز عبور کاربر'
            ]);
        }
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

