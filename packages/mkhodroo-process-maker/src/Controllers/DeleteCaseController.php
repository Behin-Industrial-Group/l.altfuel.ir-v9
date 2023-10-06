<?php 

namespace Mkhodroo\MkhodrooProcessMaker\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SoapClient;

class DeleteCaseController extends Controller
{
    private $accessToken;

    public function __construct() {
    }
    function byCaseId($caseId) {
        $this->accessToken = AuthController::getAccessToken();
        return CurlRequestController::delete(
            $this->accessToken, 
            "/api/1.0/workflow/cases/$caseId"
        );
    }
}

class variableStruct {
    public $name;
  }