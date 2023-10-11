<?php 

namespace Mkhodroo\MkhodrooProcessMaker;

use App\CustomClasses\SimpleXLSX;
use Illuminate\Support\Facades\Route;
use Mkhodroo\MkhodrooProcessMaker\Controllers\AuthController;
use Mkhodroo\MkhodrooProcessMaker\Controllers\CaseController;
use Mkhodroo\MkhodrooProcessMaker\Controllers\CurlRequestController;
use Mkhodroo\MkhodrooProcessMaker\Controllers\DeleteCaseController;
use Mkhodroo\MkhodrooProcessMaker\Controllers\DraftCaseController;
use Mkhodroo\MkhodrooProcessMaker\Controllers\DynaFormController;
use Mkhodroo\MkhodrooProcessMaker\Controllers\GetCaseVarsController;
use Mkhodroo\MkhodrooProcessMaker\Controllers\InboxController;
use Mkhodroo\MkhodrooProcessMaker\Controllers\InputDocController;
use Mkhodroo\MkhodrooProcessMaker\Controllers\NewCaseController;
use Mkhodroo\MkhodrooProcessMaker\Controllers\PMVacationController;
use Mkhodroo\MkhodrooProcessMaker\Controllers\ProcessController;
use Mkhodroo\MkhodrooProcessMaker\Controllers\SetCaseVarsController;
use Mkhodroo\MkhodrooProcessMaker\Controllers\StartCaseController;
use Mkhodroo\MkhodrooProcessMaker\Controllers\TaskController;
use Mkhodroo\MkhodrooProcessMaker\Controllers\ToDoCaseController;
use Mkhodroo\MkhodrooProcessMaker\Controllers\TriggerController;
use Mkhodroo\MkhodrooProcessMaker\Controllers\VariableController;

Route::name('MkhodrooProcessMaker.')->prefix('pm')->middleware(['web', 'auth', 'access'])->group(function(){
    Route::get('test', function(){
        $docs = InputDocController::list("55328747465212ff51cf735075979441");
        $doc = collect($docs)->where('app_doc_uid', "2642967896523d5d0875784005814484");
        foreach($doc as $doc){
            echo "<a href='https://pmaker.altfuel.ir/sysworkflow/en/neoclassic/$doc->app_doc_link' target='_blank'>$doc->app_doc_filename</a>";
        }
        // exit();
        // echo DynaFormController::getHtml("", "");
        $json =  DynaFormController::getJson("61815949564e4999e9835d8060262100", "64799933164f74dfc477a29049824083");
        $content = json_decode($json->dyn_content);
        // $fields = $content->items[0]->items;
        // $html = '';
        // foreach($fields as $rows){
        //     foreach($rows as $field){
        //         if($field->type == "text"){
        //             $html .= "<div class='col-sm-$field->colSpan'>";
        //             $html .= "$field->label: <input type='text' name='$field->name'>";
        //             $html .= "</div>";
        //         }
        //         if($field->type == "textarea"){
        //             $html .= "<div class='col-sm-$field->colSpan'>";
        //             $html .= "$field->label: <textarea name='$field->name'></textarea>";
        //             $html .= "</div>";

        //         }
        //         if($field->type == 'radio'){
        //             $html .= "<div class='col-sm-$field->colSpan'>";
        //             $html .= "$field->label: ";
        //             foreach($field->options as $opt){
        //                 $html .= "<input type='radio' name='$field->name'>$opt->label <br>";
        //             }
        //             $html .= "</div>";
        //         }
        //     }
        // }
        // return $html;
        echo "<pre>";
        foreach($content->items[0]->items as $rows){
            foreach ($rows as $field) {
                if(isset($field->type)){
                    echo $field->name . ' - ';
                    echo $field->type . '<br>';
                }else{
                    print_r($field);
                }
            }
        }
        echo "</pre>";
        echo "<pre>";
        print_r($content->items[0]->items);
        echo "</pre>";
        return ;
        $excel = SimpleXLSX::parse(public_path('task.xlsx'));
        $rows = $excel->rows();
        for ($i = 1; $i < count($rows); $i++) {
            $pro_uid = $rows[$i][0];
            $task_uid = $rows[$i][1];
            $task_title = $rows[$i][2];
            echo "$pro_uid | $task_uid | $task_title <br>";
            TaskController::saveToDb($pro_uid, $task_uid, $task_title);
            // echo $mobile . '<br>';
            // $sms->send($mobile, $body);
        }

        $excel = SimpleXLSX::parse(public_path('process_variables.xlsx'));
        $rows = $excel->rows();
        for ($i = 1; $i < count($rows); $i++) {
            $pro_uid = $rows[$i][2];
            $var_uid = $rows[$i][1];
            $var_title = $rows[$i][4];
            $type = $rows[$i][5];
            $default = $rows[$i][12];
            $accepted_value = $rows[$i][13];
            echo "$pro_uid | $var_uid | $var_title | $type | $default | $accepted_value <br>";
            VariableController::saveToDb($pro_uid, $var_uid, $var_title, $type, $accepted_value, $default);
            // echo $mobile . '<br>';
            // $sms->send($mobile, $body);
        }
    });
    Route::get('inbox', [CaseController::class, 'get'])->name('inbox');
    Route::get('new-case', [CaseController::class, 'newCase'])->name('newCase');
    Route::name('report.')->prefix('report')->group(function(){
        Route::get('number-of-my-vacations', [PMVacationController::class, 'numberOfMyVacation'])->name('numberOfMyVacation');
    });
    Route::name('forms.')->prefix('forms')->group(function(){
        Route::get('start', [StartCaseController::class, 'form'])->name('start');
        Route::get('todo', [ToDoCaseController::class, 'form'])->name('todo');
        Route::get('draft', [DraftCaseController::class, 'form'])->name('draft');
    });

    Route::name('api.')->prefix('api')->group(function(){
        Route::get('start-process', [StartCaseController::class, 'get'])->name('startProcess');
        Route::post('new-case', [NewCaseController::class, 'create'])->name('newCase');
        Route::get('todo', [ToDoCaseController::class, 'getMyCase'])->name('todo');
        Route::get('draft', [DraftCaseController::class, 'getMyCase'])->name('draft');
        Route::post('get-case-dynaForm', [DynaFormController::class, 'get'])->name('getCaseDynaForm');
        Route::post('save-and-next', [SetCaseVarsController::class, 'saveAndNext'])->name('saveAndNext');
        Route::post('save', [SetCaseVarsController::class, 'save'])->name('save');
        Route::get('get-case-vars/{caseId}', [GetCaseVarsController::class, 'getByCaseId'])->name('getCaseVars');
        Route::get('get-case-info/{caseId}/{delIndex}', [CaseController::class, 'getCaseInfo'])->name('getCaseInfo');
        Route::get('delete-case/{caseId}', [DeleteCaseController::class, 'byCaseId'])->name('deleteCase');
        Route::get('get-trigger-list', [TriggerController::class, 'list'])->name('getTriggerList');
        Route::get('get-task/{taskId}', [TaskController::class, 'getByTaskId'])->name('getTask');
        Route::get('get-tasks-by-process/{processId}', [TaskController::class, 'getByProcessId'])->name('getTaskByProcessId');

        Route::name('process.')->prefix('process')->group(function(){
            Route::get('get-by-id/{process_id}', [ProcessController::class, 'getNameById']);
        });
    });
});