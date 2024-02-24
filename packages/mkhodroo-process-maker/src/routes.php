<?php

namespace Mkhodroo\MkhodrooProcessMaker;

use App\CustomClasses\SimpleXLSX;
use Exception;
use Illuminate\Support\Facades\Route;
use Mkhodroo\MkhodrooProcessMaker\Controllers\AuthController;
use Mkhodroo\MkhodrooProcessMaker\Controllers\CaseController;
use Mkhodroo\MkhodrooProcessMaker\Controllers\CaseTrackerController;
use Mkhodroo\MkhodrooProcessMaker\Controllers\CurlRequestController;
use Mkhodroo\MkhodrooProcessMaker\Controllers\DeleteCaseController;
use Mkhodroo\MkhodrooProcessMaker\Controllers\DoneCaseController;
use Mkhodroo\MkhodrooProcessMaker\Controllers\DraftCaseController;
use Mkhodroo\MkhodrooProcessMaker\Controllers\DynaFormController;
use Mkhodroo\MkhodrooProcessMaker\Controllers\GetCaseVarsController;
use Mkhodroo\MkhodrooProcessMaker\Controllers\InboxController;
use Mkhodroo\MkhodrooProcessMaker\Controllers\InputDocController;
use Mkhodroo\MkhodrooProcessMaker\Controllers\NewCaseController;
use Mkhodroo\MkhodrooProcessMaker\Controllers\PMVacationController;
use Mkhodroo\MkhodrooProcessMaker\Controllers\ProcessController;
use Mkhodroo\MkhodrooProcessMaker\Controllers\ProcessMapController;
use Mkhodroo\MkhodrooProcessMaker\Controllers\SetCaseVarsController;
use Mkhodroo\MkhodrooProcessMaker\Controllers\StartCaseController;
use Mkhodroo\MkhodrooProcessMaker\Controllers\StepController;
use Mkhodroo\MkhodrooProcessMaker\Controllers\TaskController;
use Mkhodroo\MkhodrooProcessMaker\Controllers\ToDoCaseController;
use Mkhodroo\MkhodrooProcessMaker\Controllers\TriggerController;
use Mkhodroo\MkhodrooProcessMaker\Controllers\VariableController;
use Illuminate\Http\Request;
use Mkhodroo\PMReport\Controllers\TableController;

Route::name('MkhodrooProcessMaker.')->prefix('pm')->middleware(['web', 'auth', 'access'])->group(function () {
    Route::get('test', function () {
        $accessToken = AuthController::getAccessToken();
        
        $inbox =  CurlRequestController::send(
            $accessToken,
            "/api/1.0/workflow/home/todo"
        );
        $r = new Request([
            'table_name' => 'application'
        ]);
        $application = TableController::getData($r);
        return $application;
        echo "<pre>";
        $a =  CurlRequestController::send(
            $accessToken,
            "/api/1.0/workflow/cases/2145753196538ef1c4d5f25096423406/tasks"
        );
        print_r($a);
    });
    Route::get('test1', function () {
        $accessToken = AuthController::getAccessToken();
        echo "<pre>";
        $a =  CurlRequestController::send(
            $accessToken,
            "/api/1.0/workflow/cases/2145753196538ef1c4d5f25096423406/tasks"
        );
        echo "<table>";
        foreach ($a as $a) {
            echo "<tr>";
            echo "<td>";
            echo $a->tas_title;
            echo "</td>";
            echo "<td>";
            echo $a->usr_firstname . ' ' . $a->usr_lastname . "($a->usr_username)";
            echo "</td>";
            echo "<td>";
            echo $a->status;
            echo "</td>";
            foreach ($a->delegations as $del) {
                if ($del->del_init_date != 'Case not started yet') {
                    echo "<td>";
                    echo $del->del_init_date;
                    echo "</td>";
                    echo "<td>";
                    echo $del->del_finish_date;
                    echo "</td>";
                    echo "<td>";
                    echo $del->del_duration;
                    echo "</td>";
                }
            }
            echo "<tr>";
        }
        echo "</table>";
    });
    Route::get('inbox', [CaseController::class, 'get'])->name('inbox');
    Route::get('new-case', [CaseController::class, 'newCase'])->name('newCase');
    Route::name('report.')->prefix('report')->group(function () {
        Route::get('number-of-my-vacations', [PMVacationController::class, 'numberOfMyVacation'])->name('numberOfMyVacation');
    });
    Route::name('forms.')->prefix('forms')->group(function () {
        Route::get('start', [StartCaseController::class, 'form'])->name('start');
        Route::get('todo', [ToDoCaseController::class, 'form'])->name('todo');
        Route::get('draft', [DraftCaseController::class, 'form'])->name('draft');
        Route::get('done', [DoneCaseController::class, 'form'])->name('done');
    });

    Route::name('api.')->prefix('api')->group(function () {
        Route::get('start-process', [StartCaseController::class, 'get'])->name('startProcess');
        Route::post('new-case', [NewCaseController::class, 'create'])->name('newCase');
        Route::get('todo', [ToDoCaseController::class, 'getMyCase'])->name('todo');
        Route::get('draft', [DraftCaseController::class, 'getMyCase'])->name('draft');
        Route::get('done', [DoneCaseController::class, 'getMyCase'])->name('done');
        Route::post('get-case-dynaForm', [DynaFormController::class, 'get'])->name('getCaseDynaForm');
        Route::post('get-case-mainForm', [DoneCaseController::class, 'mainForm'])->name('getCaseMainForm');
        Route::post('save-and-next', [SetCaseVarsController::class, 'saveAndNext'])->name('saveAndNext');
        Route::post('save', [SetCaseVarsController::class, 'save'])->name('save');
        Route::get('get-case-vars/{caseId}', [GetCaseVarsController::class, 'getByCaseId'])->name('getCaseVars');
        Route::get('get-case-info/{caseId}/{delIndex}', [CaseController::class, 'getCaseInfo'])->name('getCaseInfo');
        Route::get('get-case-main-info/{caseId}', [GetCaseVarsController::class, 'getMainInfoByCaseId'])->name('getMainInfoByCaseId');
        Route::get('get-case-process-map/{caseId}', [ProcessMapController::class, 'getCaseProcessMap'])->name('getCaseProcessMap');
        Route::get('delete-case/{caseId}', [DeleteCaseController::class, 'byCaseId'])->name('deleteCase');
        Route::get('get-trigger-list', [TriggerController::class, 'list'])->name('getTriggerList');
        Route::get('get-task/{taskId}', [TaskController::class, 'getByTaskId'])->name('getTask');
        Route::get('get-tasks-by-process/{processId}', [TaskController::class, 'getByProcessId'])->name('getTaskByProcessId');

        Route::name('process.')->prefix('process')->group(function () {
            Route::get('get-by-id/{process_id}', [ProcessController::class, 'getNameById']);
        });
    });
});
