<?php 

namespace Mkhodroo\MkhodrooProcessMaker\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class DynaFormController extends Controller
{
    private $accessToken;

    public function __construct() {
    }
    function get(Request $r) {

        $task = TaskController::getByTaskId($r->taskId);
        $triggers =  TriggerController::list();
        foreach($triggers as $trigger){
            TriggerController::excute($trigger->guid, $r->caseId, $r->delIndex);
        }
        $viewName = $task->dynaform;
        $variable_values = (new GetCaseVarsController())->getByCaseId($r->caseId);
        $variables = VariableController::getByProcessId($r->processId);
        return view("PMViews::dynamic-forms." . $viewName)->with([
            'vars' => $variables,
            'variable_values' => $variable_values,
            'processId' => $r->processId,
            'processTitle' => $r->processTitle,
            'caseId' => $r->caseId,
            'caseTitle' => $r->caseTitle,
            'delIndex' => $r->delIndex,
        ]);
    }
}