<?php 

namespace Mkhodroo\MkhodrooProcessMaker\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SoapClient;

class GetCaseVarsController extends Controller
{
    private $accessToken;

    public function __construct() {
    }
    function getByCaseId($caseId) {
        // $sessionId = AuthController::wsdl_login()->message;
        // $client = new SoapClient(str_replace('https', 'http', env('PM_SERVER')). '/sysworkflow/en/green/services/wsdl2');
        // $p = new variableStruct();
        // $p->name = 'clientName';     //a case variable
        // $s = new variableStruct();
        // $s->name = 'SYS_LANG';       //a system variable
        // $variables = array($p, $s);
        
        // $params = array(array('sessionId'=>$sessionId, 'caseId' => $caseId, 'variables'=> $variables));
        // $result = $client->__SoapCall('getVariables', $params);
        // return collect($result);

        $this->accessToken = AuthController::getAccessToken();
        return CurlRequestController::send(
            $this->accessToken, 
            "/api/1.0/workflow/cases/$caseId/variables"
        );
    }
}

class variableStruct {
    public $name;
  }