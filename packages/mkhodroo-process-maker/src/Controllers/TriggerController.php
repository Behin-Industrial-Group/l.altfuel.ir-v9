<?php 

namespace Mkhodroo\MkhodrooProcessMaker\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use SoapClient;

class TriggerController extends Controller
{
    public static function list(){
        $sessionId = AuthController::wsdl_login()->message;
        $client = new SoapClient(str_replace('https', 'http', env('PM_SERVER')). '/sysworkflow/en/green/services/wsdl2');
        
        $params = array(array('sessionId'=>$sessionId));
        $params = array(
            array(
                'sessionId'=>$sessionId
            )
        );
        $result = $client->__SoapCall('triggerList', $params);
        return $result->triggers;
    }
    
    public static function excute($triggerId, $caseId, $delIndex) {
        $sessionId = AuthController::wsdl_login()->message;
        $client = new SoapClient(str_replace('https', 'http', env('PM_SERVER')). '/sysworkflow/en/green/services/wsdl2');
        
        $params = array(array('sessionId'=>$sessionId));
        $params = array(
            array(
                'sessionId'=>$sessionId, 
                'caseId'=> $caseId,
                'triggerIndex'=> $triggerId,
                'delIndex'=> $delIndex
            )
        );
        $result = $client->__SoapCall('executeTrigger', $params);
        return $result;
    }
}