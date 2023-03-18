<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\IssuesModel;
use App\IssuesCatagoryModel;
use App\MarakezModel;
use File;
use Verta;
use App\Traits\reCAPTCHA;
use App\CustomClasses\IssuesCatagory;
use App\CustomClasses\Logs;
use App\CustomClasses\Access;
use App\CustomClasses\ExcelReader;
use App\Enums\EnumsEntity;
use SoapClient;
use App\User;
use App\LogsModel;


class ReportIrngvPollController extends Controller
{
    public function show_list()
    {


        return view('admin.report.irngv.polls-list')->with([
            'questions' => EnumsEntity::irngv_poll_question,
            'report' => IrngvPollAnswerController::get_answer_avg_of_all_question(),
            'number_report' => IrngvPollAnswerController::get_number_of_special_answer_of_all_question(),
        ]);
    }
    
}
