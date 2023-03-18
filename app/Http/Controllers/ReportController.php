<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\IssuesModel;
use App\Models\IssuesCatagoryModel;
use App\Models\MarakezModel;
use File;
use Verta;
use App\Traits\reCAPTCHA;
use App\CustomClasses\IssuesCatagory;
use App\CustomClasses\Logs;
use App\CustomClasses\Access;
use SoapClient;
use App\Models\User;
use App\Models\LogsModel;
use App\Repository\RReport;
use Carbon\Carbon;
use Exception;
use Hekmatinasser\Verta\Facades\Verta as FacadesVerta;
use Hekmatinasser\Verta\Verta as VertaVerta;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    protected $RReport;

    public function __construct()
    {
        $this->RReport = new RReport();
    }
    public function CreateCallReportForm()
    {
        return view('admin.report.call.create');
    }

    public function CreateCallReport(Request $request)
    {
        return $this->RReport->SetCallReport($request);
    }

    public function ShowCallReport()
    {
        return view('admin.report.call.show');
    }

    public function GetCallReport($date)
    {
        // $date = explode("-", $date);
        // Log::info($date);

        $date = VertaVerta::getGregorian($date);
        // Log::info(gettype($date));
        // $date = Carbon::create($date[0], $date[1], $date[2])->toDateString();

        return $this->RReport->GetCallReport($date);
    }

    public function ticketform()
    {
        Access::check('Reports_issues');
        
        $catagories = IssuesCatagoryModel::get();
        $issues = IssuesModel::get();
        
        $report['total']['total'] = IssuesModel::count();
        $report['total']['unanswer'] = IssuesModel::where('status', 0)->count(); 
        $report['total']['tracking'] = IssuesModel::where('trackinglater', 'yes')->orWhere('trackinglater', 'y2n')->count();
        $report['total']['unanswer_tracking'] = IssuesModel::where('trackinglater', 'yes')->count();
        $report['total']['junk'] = IssuesModel::where('status', 4)->count();
        
        
        foreach($catagories as $catagory)
        {
            // TOTAL
            $total = IssuesModel::where('catagory' , $catagory->name);
            $unanswer = IssuesModel::where('catagory' , $catagory->name)->where('status' , 0);
            $tracking = IssuesModel::where('catagory' , $catagory->name)->where(function($q){
                $q->where('trackinglater' ,'yes')->orWhere('trackinglater', 'y2n');
            });
            $unanswer_tracking = IssuesModel::where('catagory' , $catagory->name)->where('trackinglater' , 'yes');
            $junk = IssuesModel::where('catagory' , $catagory->name)->where('status' , 4);
            
            $report[$catagory->name]['total'] = $total->count();
            $report[$catagory->name]['unanswer'] = $unanswer->count();
            $report[$catagory->name]['tracking'] = $tracking->count();
            $report[$catagory->name]['unanswer_tracking'] = $unanswer_tracking->count();
            $report[$catagory->name]['junk'] = $junk->count();
            
            if($catagory->name == 'irngv')
            {
                $report['agancy']['total'] = $total->join("marakez1", "issues.NationalID", "marakez1.NationalID")->count();
                $report['agancy']['unanswer'] = $unanswer->join("marakez1", "issues.NationalID", "marakez1.NationalID")->count();
                $report['agancy']['tracking'] = $tracking->join("marakez1", "issues.NationalID", "marakez1.NationalID")->count();
                $report['agancy']['unanswer_tracking'] = $unanswer_tracking->join("marakez1", "issues.NationalID", "marakez1.NationalID")->count();
                $report['agancy']['junk'] = $junk->join("marakez1", "issues.NationalID", "marakez1.NationalID")->count();
            }
            
            // Daily
            for($i=1;$i<8;$i++)
            {
                $date = Verta();
                $d = $date->subDays($i)->formatDate();
                
                $chartData["$catagory->name"]["$d"]["total"] = IssuesModel::where('catagory', $catagory->name)->where("created_at", "like", "%$d%")->count();
                $chartData["$catagory->name"]["$d"]["answer"] = IssuesModel::where('catagory', $catagory->name)->where("updated_at", "like", "%$d%")->where('status' , 1)->count();
            
                $numberPerCatagoryPerDay["$catagory->name"]["$d"]["total"] = IssuesModel::
                    where('catagory', $catagory->name)
                    ->where("created_at", "like", "%$d%")
                    ->count();
                    
                $numberPerCatagoryPerDay["$catagory->name"]["$d"]["answer"] = IssuesModel::
                    where('catagory', $catagory->name)
                    ->where("created_at", "like", "%$d%")
                    ->where("updated_at", "like", "%$d%")
                    ->where('status' , 1)
                    ->count();
            }
            
            //Weekly
            $date = Verta();
            $d = $date->subDays(7)->formatDate();
            $numberPerCatagoryWeekly["$catagory->name"]["total"] = IssuesModel::
                where("created_at", "not like", "%2020%")
                ->where("catagory", "$catagory->name")
                ->where("created_at", ">=", "$d")
                ->count();
                
            $numberPerCatagoryWeekly["$catagory->name"]["unanswer"] = IssuesModel::
                where("created_at", "not like", "%2020%")
                ->where("catagory", "$catagory->name")
                ->where("created_at", ">=", "$d")
                ->where("status", 0)
                ->count();
                
            $numberPerCatagoryWeekly["$catagory->name"]["trackingUnanswer"] = IssuesModel::
                where("created_at", "not like", "%2020%")
                ->where("catagory", "$catagory->name")
                ->where("created_at", ">=", "$d")
                ->where("trackingLater", "yes")
                ->count();
            
            //BEFORE LAST WEEK
            $numberPerCatagoryBeforeLastWeek["$catagory->name"]["total"] = IssuesModel::
                where("catagory", "$catagory->name")
                ->where("created_at", "<", "$d")
                ->count();
                
            $numberPerCatagoryBeforeLastWeek["$catagory->name"]["unanswer"] = IssuesModel::
                where("catagory", "$catagory->name")
                ->where("created_at", "<", "$d")
                ->where("status", 0)
                ->count();
                
            $numberPerCatagoryBeforeLastWeek["$catagory->name"]["trackingUnanswer"] = IssuesModel::
                where("catagory", "$catagory->name")
                ->where("created_at", "<", "$d")
                ->where("trackingLater", "yes")
                ->count();
                
            //Weekly For Agancy
            if($catagory->name == "irngv"){
                $numberPerCatagoryWeekly["agancy"]["total"] = IssuesModel::join("marakez1", "issues.NationalID", "marakez1.NationalID")
                    ->where("issues.created_at", "not like", "%2020%")
                    ->where("issues.catagory", "$catagory->name")
                    ->where("issues.created_at", ">=", "$d")
                    ->count();  
                    
                $numberPerCatagoryWeekly["agancy"]["unanswer"] = IssuesModel::join("marakez1", "issues.NationalID", "marakez1.NationalID")
                    ->where("issues.created_at", "not like", "%2020%")
                    ->where("issues.catagory", "$catagory->name")
                    ->where("issues.created_at", ">=", "$d")
                    ->where("issues.status", 0)
                    ->count();
                    
                $numberPerCatagoryWeekly["agancy"]["trackingUnanswer"] = IssuesModel::join("marakez1", "issues.NationalID", "marakez1.NationalID")
                    ->where("issues.created_at", "not like", "%2020%")
                    ->where("issues.catagory", "$catagory->name")
                    ->where("issues.created_at", ">=", "$d")
                    ->where("issues.trackingLater", "yes")
                    ->count();
                    
                //BEFORE LAST WEEK
                $numberPerCatagoryBeforeLastWeek["agancy"]["total"] = IssuesModel::join("marakez1", "issues.NationalID", "marakez1.NationalID")
                    ->where("catagory", "$catagory->name")
                    ->where("created_at", "<", "$d")
                    ->count();
                    
                $numberPerCatagoryBeforeLastWeek["agancy"]["unanswer"] = IssuesModel::join("marakez1", "issues.NationalID", "marakez1.NationalID")
                    ->where("catagory", "$catagory->name")
                    ->where("created_at", "<", "$d")
                    ->where("status", 0)
                    ->count();
                    
                $numberPerCatagoryBeforeLastWeek["agancy"]["trackingUnanswer"] = IssuesModel::join("marakez1", "issues.NationalID", "marakez1.NationalID")
                    ->where("catagory", "$catagory->name")
                    ->where("created_at", "<", "$d")
                    ->where("trackingLater", "yes")
                    ->count();
            }
            
        }
        
        $users = $this->getUsers();
        foreach($users as $user)
        {
            for($i=1;$i<8;$i++)
            {
                $date = Verta();
                $d = $date->subDays($i)->formatDate();  
                $numberPerUserPerDay["$user->display_name"]["$d"]["answer"] = LogsModel::join('issues', 'logs.record_id', 'issues.id')
                    ->Where('logs.user_id',"$user->id")
                    ->where('logs.table_name', "issues")
                    ->where('issues.updated_at', 'like', "%$d%")
                    ->where('issues.created_at', 'like', "%$d%")
                    ->count();
                    
                $numberPerUserPerDay["$user->display_name"]["$d"]["trackingLater"] = LogsModel::join('issues', 'logs.record_id', 'issues.id')
                    ->Where('logs.user_id',"$user->id")
                    ->where('logs.table_name', "issues")
                    ->where('issues.updated_at', 'like', "%$d%")
                    ->where('issues.created_at', 'like', "%$d%")
                    ->where('issues.trackingLater', 'yes')
                    ->count();
            }
            
            // WEEKLY
            $date = Verta();
            $d = $date->subDays(7)->formatDate();  
            $numberPerUserWeekly["$user->id"]['answer'] = LogsModel::join('issues', 'logs.record_id', 'issues.id')
                ->where("issues.created_at", "not like", "%2020%")
                ->Where('logs.user_id',"$user->id")
                ->where('logs.table_name', "issues")
                ->where('issues.created_at', '>=', "$d")
                ->where('issues.updated_at', '>=', "$d")
                ->where('issues.status', 1)
                ->count();
                
            $numberPerUserWeekly["$user->id"]['trackingUnanswer'] = LogsModel::join('issues', 'logs.record_id', 'issues.id')
                ->where("issues.created_at", "not like", "%2020%")
                ->Where('logs.user_id',"$user->id")
                ->where('logs.table_name', "issues")
                ->where('issues.created_at', '>=', "$d")
                ->where('issues.updated_at', '>=', "$d")
                ->where('issues.trackingLater', 'yes')
                ->count();
                
            //BEFORE LAST WEEK
            $numberPerUserBeforeLastWeek["$user->id"]['answer'] = LogsModel::join('issues', 'logs.record_id', 'issues.id')
                ->where("issues.created_at", "not like", "%2020%")
                ->Where('logs.user_id',"$user->id")
                ->where('logs.table_name', "issues")
                ->where('issues.created_at', '<', "$d")
                ->where('issues.updated_at', '<', "$d")
                ->where('issues.status', 1)
                ->count();
                
            $numberPerUserBeforeLastWeek["$user->id"]['trackingUnanswer'] = LogsModel::join('issues', 'logs.record_id', 'issues.id')
                ->where("issues.created_at", "not like", "%2020%")
                ->Where('logs.user_id',"$user->id")
                ->where('logs.table_name', "issues")
                ->where('issues.created_at', '<', "$d")
                ->where('issues.updated_at', '<', "$d")
                ->where('issues.trackingLater', 'yes')
                ->count();
        }
        
        /*
        foreach($issues as $issue)
        {
            $report["$issue->catagory"]['total'] = $report["$issue->catagory"]['total'] +1;
            //return $report["$issue->catagory"]['total'];
            
            if($issue->status == 0){
                $report["$issue->catagory"]['unanswer'] = $report["$issue->catagory"]['unanswer'] +1;
            }
            if($issue->trackinglater == 'yes' || $issue->trackinglater == 'y2n'){
                $report["$issue->catagory"]['tracking'] = $report["$issue->catagory"]['tracking'] +1;
            }
            if($issue->trackinglater == 'yes'){
                $report["$issue->catagory"]['unanswer_tracking'] = $report["$issue->catagory"]['unanswer_tracking'] +1;
            }
            
            if($issue->status == 4){
                $report["$issue->catagory"]['junk'] = $report["$issue->catagory"]['junk'] +1;
            }
            
                
        }
        */
        
        $date = Verta();
        
        $avgAnsweredTime = $this->answerTimeAvg();
        $avgAnsweredChars = $this->answerCharsAvg();
        $numberOfAnsweredIssues = $this->numberOfAnsweredIssuesByUsers();
        
        //return var_dump($numberOfAnsweredIssues);
        
        return view('admin.report.ticket')
                    ->with(
                        [
                            'catagories' => $catagories,
                            'report' => $report,
                            'date' => $date,
                            'chartData' => $chartData,
                            'avgAnsweredTime' => $avgAnsweredTime,
                            'avgAnsweredChars' => $avgAnsweredChars,
                            'numberOfAnsweredIssues' => $numberOfAnsweredIssues,
                            'users' => $users,
                            'numberPerCatagoryPerDay' => $numberPerCatagoryPerDay,
                            'numberPerUserPerDay' => $numberPerUserPerDay,
                            'numberPerCatagoryWeekly' => $numberPerCatagoryWeekly,
                            'numberPerCatagoryBeforeLastWeek' => $numberPerCatagoryBeforeLastWeek,
                            'numberPerUserWeekly' => $numberPerUserWeekly,
                            'numberPerUserBeforeLastWeek' => $numberPerUserBeforeLastWeek,
                        ]);
    }
    
    public function answerTimeAvg()
    {
        Access::check('Reports_issues');
        
        $catagories = IssuesCatagoryModel::get();
        $issues = IssuesModel::get();
        
        foreach($catagories as $catagory)
        {
            $sumOfDiffMinutes["$catagory->name"] = 0;
            $numberOfIssues["$catagory->name"] = 0;
        }
        
        foreach($issues as $issue)
        {
            $cDate = explode('-',$issue->created_at);
            $uDate = explode('-',$issue->updated_at);
            
            if($cDate[0] != 2020 && $uDate[0] != 2020)
            {
                if($issue->status != 0 && ($issue->trackinglater == 'no' || $issue->trackinglater == 'y2n') && $cDate[0] == 1399)
                {
                    $issueCreatedDate = Verta("$issue->created_at");
                    $issueAnswerDate  = Verta("$issue->updated_at");    
                    $diffDays = abs($issueCreatedDate->diffMinutes($issueAnswerDate));
                    
                    $sumOfDiffMinutes["$issue->catagory"] = $diffDays + $sumOfDiffMinutes["$issue->catagory"];
                    $numberOfIssues["$issue->catagory"] = $numberOfIssues["$issue->catagory"] + 1;
                }
                
            }
        }
        $i=1;
        foreach($catagories as $catagory)
        {
            $avgAnsweredTime[$i]['catagory'] = $catagory->name;
            $avgAnsweredTime[$i]['catagory_faname'] = IssuesCatagoryModel::where('name', "$catagory->name")->first()->fa_name;
            
            if( $numberOfIssues["$catagory->name"] == 0 )
                $numberOfIssues["$catagory->name"] = 0.1;
                
            $avgAnsweredTime[$i]['avg'] = $sumOfDiffMinutes["$catagory->name"] / (24*60*$numberOfIssues["$catagory->name"]);
            
            $i++;
        }
    
        return $avgAnsweredTime;
    }
    
    public function answerCharsAvg()
    {
        Access::check('Reports_issues');
        
        $catagories = IssuesCatagoryModel::get();
        $issues = IssuesModel::get();
        
        foreach($catagories as $catagory)
        {
            $sumOfChars["$catagory->name"] = 0;
            $numberOfIssues["$catagory->name"] = 0;
        }
        
        foreach($issues as $issue)
        {
            $cDate = explode('-',$issue->created_at);
            $uDate = explode('-',$issue->updated_at);
            
            if($cDate[0] != 2020 && $uDate[0] != 2020)
            {
                if($issue->status != 0 && ($issue->trackinglater == 'no' || $issue->trackinglater == 'y2n') && $cDate[0] == 1399) // from 1399
                {
                    $sumOfChars["$issue->catagory"] = $sumOfChars["$issue->catagory"] + strlen($issue->answer);
                    $numberOfIssues["$issue->catagory"] = $numberOfIssues["$issue->catagory"] + 1;
                }
                
            }
        }
        $i=1;
        foreach($catagories as $catagory)
        {
            $avgAnsweredChar[$i]['catagory'] = $catagory->name;
            $avgAnsweredChar[$i]['catagory_faname'] = IssuesCatagoryModel::where('name', "$catagory->name")->first()->fa_name;            
            
            if( $numberOfIssues["$catagory->name"] == 0 )
                $numberOfIssues["$catagory->name"] = 0.1;
                
            $avgAnsweredChar[$i]['avg'] = $sumOfChars["$catagory->name"] / ($numberOfIssues["$catagory->name"]);
            
            $i++;
        }
    
        return $avgAnsweredChar;
    }
    
    
    
    private $issuesTableName = "issues";
    
    private function logsFor($week = '')
    {
        return LogsModel::where('updated_at', '>=', "%$week%");
    }
    
    private function numberOfAnsweredIssuesByUser($user_id)
    {
        $table_name = $this->issuesTableName;
        $date = Verta();
        $week = $date->subDays(7);
        
        return $this->logsFor($week)->where('table_name',$table_name)->where('user_id',$user_id)->count();
    }
    
    private function getUser($id)
    {
        $user = User::where('id', $id)->get();
        return $user;
    }
    
    private function getUsers()
    {
        return User::where("showInReport", 1)->get();
    }
    
    private function numberOfCharsOfAnsweredIssuesByUser($user_id)
    {
        $table_name = $this->issuesTableName;
        $date = Verta();
        $week = $date->subDays(7);
        
        $userLogs =  $this->logsFor($week)->where('table_name', $table_name)->where('user_id', $user_id)->get();
        $noUserLogs =  $this->logsFor($week)->where('table_name', $table_name)->where('user_id', $user_id)->count();
        $sum = 0;
        foreach( $userLogs as $row )
        {
            $sum = strlen($row->descripe) + $sum;
        }
        
        if($noUserLogs == 0)
            $avgChars = 0;
        else
            $avgChars = $sum / $noUserLogs;
        
        return round($avgChars);
        
    }
    
    private function numberOfAnsweredIssuesByUsers()
    {
        $users = $this->getUsers();
        $i=0;
        foreach($users as $user)
        {
            if(is_null($user->display_name))
            {
                $data[$i]['name'] = "تعریف نشده";
                $data[$i]['numberOfAnswered'] = 0;
                $data[$i]['avgChars'] = 0;
            }else
            {
                $data[$i]['name'] = $user->display_name;
                $data[$i]['numberOfAnswered'] = $this->numberOfAnsweredIssuesByUser($user->id);
                $data[$i]['avgChars'] = $this->numberOfCharsOfAnsweredIssuesByUser($user->id);
            }
            $i++;
        }
        
        return $data;
    }

    public function license(Request $r)
    {
        return view('admin.report.license');
    }
}
