<?php 

namespace Mkhodroo\MkhodrooProcessMaker\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ToDoCaseController extends Controller
{
    private $accessToken;

    public function __construct() {
    }
    function getMyCase() {
        $this->accessToken = AuthController::getAccessToken('mkhodroo', 'Mk09376922176');
        return CurlRequestController::send(
            $this->accessToken, 
            "/api/1.0/workflow/home/todo"
        );
    }
}