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

        $process = collect(config('pm_config.process'))->where('id', $r->processId)->first();
        $cases = collect($process['case']);
        $case = $cases->where('id', $r->taskId)->first();
        $triggers =  TriggerController::list();
        foreach($triggers as $trigger){
            TriggerController::excute($trigger->guid, $r->caseId, $r->delIndex);
        }
        $viewName = $case['dynamic_view_form'];
        $variables = (new GetCaseVarsController())->getByCaseId($r->caseId);
        return view("PMViews::dynamic-forms." . $viewName)->with([
            'vars' => $variables,
            'processId' => $r->processId,
            'processTitle' => $r->processTitle,
            'caseId' => $r->caseId,
            'caseTitle' => $r->caseTitle,
            'delIndex' => $r->delIndex,
        ]);
    }
}