<?php

namespace Mkhodroo\MkhodrooProcessMaker\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use SoapClient;

class DraftCaseController extends Controller
{
    private $accessToken;

    public function __construct()
    {
    }
    function getMyCase()
    {
        $this->accessToken = AuthController::getAccessToken();
        $draft =  CurlRequestController::send(
            $this->accessToken,
            "/api/1.0/workflow/home/draft"
        );
        $inbox =  CurlRequestController::send(
            $this->accessToken,
            "/api/1.0/workflow/home/todo"
        );
        $draft->data = array_merge($draft->data, $inbox->data);
        return $draft;

        
        return CurlRequestController::send(
            $this->accessToken,
            "/api/1.0/workflow/home/draft"
        );
        $sessionId = AuthController::wsdl_login()->message;
        $client = new SoapClient(str_replace('https', 'http', env('PM_SERVER')) . '/sysworkflow/en/green/services/wsdl2');

        $params = array(array('sessionId' => $sessionId));
        $result = $client->__SoapCall('caseList', $params);
        foreach ($result->cases as $case) {
            $case->info = CaseController::getCaseInfo($case->guid, $case->delIndex);
            // CaseController::saveToDb($case->info->processId, $case->guid, $case->name);
        }
        return ['data' => $result->cases];


        $this->accessToken = AuthController::getAccessToken('admin', 'Mk09376922176');
        // return $this->accessToken;
        $draft =  CurlRequestController::send(
            $this->accessToken,
            "/api/1.0/workflow/users"
        );
        $inbox =  CurlRequestController::send(
            $this->accessToken,
            "/api/1.0/workflow/users"
        );
        $draft->data = array_merge($draft->data, $inbox->data);
        return $draft;
    }

    function form()
    {
        return view('PMViews::draft');
    }
}
