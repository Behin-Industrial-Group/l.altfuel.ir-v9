<?php

namespace Mkhodroo\MkhodrooProcessMaker\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use SoapClient;

class SetCaseVarsController extends Controller
{
    private $accessToken;

    public function __construct()
    {
    }
    function saveAndNext(Request $r)
    {
        $sessionId = AuthController::wsdl_login()->message;
        $client = new SoapClient(str_replace('https', 'http', env('PM_SERVER')) . '/sysworkflow/en/green/services/wsdl2');

        $vars = $r->except('caseId');
        $variables = array();
        foreach ($vars as $key => $val) {
            $obj = new variableListStruct();
            $obj->name = $key;
            $obj->value = $val;
            $variables[] = $obj;
        }
        $params = array(array('sessionId' => $sessionId, 'caseId' => $r->caseId, 'variables' => $variables));
        $result = $client->__SoapCall('sendVariables', $params);
        if ($result->status_code != 0)
            return response($result->message, 400);

        // $params = array(array('sessionId' => $sessionId, 'caseId' => $r->app_uid, 'delIndex' => $r->del_index, 'userIdSource' => "00000000000000000000000000000001", 'userIdTarget' => "$r->user_logged"));
        // $result = $client->__SoapCall('reassignCase', $params);
        // if ($result->status_code != 0)
        //     return response($result->message, 400);

        return RouteCaseController::next($r->caseId, $r->del_index);
        return response("انجام شد", 200);
        // $this->accessToken = AuthController::getAccessToken('mkhodroo', 'Mk09376922176');
        // foreach($r->all() as $key=>$value){
        //     if(!($key === "app_uid" or $key === "del_index")){
        //         CurlRequestController::put(
        //             $this->accessToken, 
        //             "/api/1.0/workflow/variable/$r->app_uid/$r->del_index/variable/$key",
        //             [
        //                 $key => $value,
        //                 $key . '_label' => $value
        //             ]
        //         );
        //     }

        // }
    }

    function save(Request $r)
    {
        // return $r;
        // return InputDocController::upload($r->taskId, $r->caseId, '97290740465214979a6b891095846179', $r->file('97290740465214979a6b891095846179'));
        // return $r->file('97290740465214979a6b891095846179')->getClientOriginalName();
        $sessionId = AuthController::wsdl_login()->message;
        $client = new SoapClient(str_replace('https', 'http', env('PM_SERVER')) . '/sysworkflow/en/green/services/wsdl2');

        $vars = $r->except('caseId');
        $variables = array();
        foreach ($vars as $key => $val) {
            if(gettype($val) == 'object'){
                InputDocController::upload($r->taskId, $r->caseId, $key, $r->file($key));
            }else{
                $obj = new variableListStruct();
                $obj->name = $key;
                $obj->value = $val;
                $variables[] = $obj;
            }
        }
        $params = array(array('sessionId' => $sessionId, 'caseId' => $r->caseId, 'variables' => $variables));
        $result = $client->__SoapCall('sendVariables', $params);
        if ($result->status_code != 0)
            return response($result->message, 400);
        return response("ok", 200);
    }
}

class variableListStruct
{
    public $name;
    public $value;
}
