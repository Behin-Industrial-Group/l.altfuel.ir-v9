<?php 

namespace Mkhodroo\MkhodrooProcessMaker\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Mkhodroo\MkhodrooProcessMaker\Models\PMTask;
use SoapClient;

class VariableController extends Controller
{
    public static function getByVarId($taskId){
        return PMTask::where('var_uid', $taskId)->first();
    }

    public static function getByProcessId($process_id){
        return PMTask::where('process_uid', $process_id)->get()->toArray();
    }

    public static function saveToDb($pro_uid, $task_uid, $task_title){
        PMTask::updateOrCreate(
            [
                'process_uid' => $pro_uid,
                'task_uid' => $task_uid
            ],
            [
                'task_title' => $task_title
            ]
        );
    }
    
}