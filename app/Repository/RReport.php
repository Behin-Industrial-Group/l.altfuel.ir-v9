<?php

namespace App\Repository;

use App\CustomClasses\Access;
use App\CustomClasses\SimpleXLSX;
use Exception;
use App\Models\CallReportModel as Call;
use App\Models\IssuesModel;
use App\Models\License;
use App\Models\LicenseRequest;
use Carbon\Carbon;
use DivisionByZeroError;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\CodeCoverage\BranchAndPathCoverageNotSupportedException;

class RReport
{
    protected $model;
    private $license_req_model;
    private $license_model;
    private $asnaf_report_dir;
    private $report_dir;

    public function __construct()
    {
        $this->model = new Call();
        $this->license_model = new License();
        $this->license_req_model = new LicenseRequest();
        $this->asnaf_report_dir = 'public/uploads/asnaf_report';
        $this->report_dir = public_path('uploads/report');
    }
    public function SetCallReport($r)
    {
        if(isset($r->date)){
            $date = explode("-", $r->date);
            $date = Verta::jalaliToGregorian($date[0], $date[1], $date[2]);
            $date = Carbon::create($date[0], $date[1], $date[2])->toDateString();
        }else{
            $date = Carbon::now();
        }
        $i=0;
        $results = $this->SetCallReportFromExcel($r);
        foreach($results as $key => $value){
            echo "$key: $key ";
            print_r($value);
            echo "<br>";
            $date = $date;
            $row = Call::where('ext', $key)->where('created_at', 'like', "%$date%")->first();
            if(is_null($row)){
                $row = new Call();
            }
            $row->ext = $key;
            $row->name = config("app.report.call.extensions.$key.name");
            $row->answer_percent = isset($value['answer']) ? round($value['answer'] / $value['total'] *100) : 0;
            $row->answer = isset($value['answer']) ? $value['answer'] : 0;
            $row->answer_time = isset($value['answer-time']) ? $value['answer-time'] : 0;
            $row->unanswer_percent = isset($value['unanswer']) ? round($value['unanswer'] / $value['total'] *100) : 0;
            $row->unanswer = isset($value['unanswer']) ? $value['unanswer'] : 0;
            $row->unanswer_time = 0;
            $row->busy_percent = isset($value['busy']) ? round($value['busy'] / $value['total'] *100) : 0;
            $row->busy = isset($value['busy']) ?$value['busy'] : 0;
            $row->total = $value['total'];
            $row->created_at = $date;
            $row->save();
        }
        return redirect()->back();
        exit;
        $rows = count($r->ext);
        for($i=0; $i<$rows; $i++){
            if(!is_null($r->ext[$i])){
                $date = $date;
                $row = Call::where('ext', $r->ext[$i])->where('created_at', 'like', "%$date%")->first();
                if(is_null($row)){
                    $row = new Call();
                }
                try{
                    $row->ext = $r->ext[$i];
                    
                    if(!is_null($r->name[$i])){
                        $row->name = $r->name[$i];
                    }
                    if(!is_null($r->answer_percent[$i])){
                        $row->answer_percent = $r->answer_percent[$i];
                    }
                    if(!is_null($r->answer_hour[$i]) || !is_null($r->answer_min[$i]) || !is_null($r->answer_second[$i])){
                        $row->answer_time = ($r->answer_hour[$i]*3600) + ($r->answer_min[$i]*60) + $r->answer_second[$i];
                    }
                    if(!is_null($r->unanswer_percent[$i])){
                        $row->unanswer_percent = $r->unanswer_percent[$i];
                    }
                    if(!is_null($r->unanswer_hour[$i]) || !is_null($r->unanswer_min[$i]) || !is_null($r->unanswer_second[$i])){
                        $row->unanswer_time = ($r->unanswer_hour[$i]*3600) + ($r->unanswer_min[$i]*60) + $r->unanswer_second[$i];
                    }
                    if(!is_null($r->busy_percent[$i])){
                        $row->busy_percent = $r->busy_percent[$i];
                    }
                    if(!is_null($r->total[$i])){
                        $row->total = $r->total[$i];
                    }

                    $row->created_at = $date;
                    $row->save();
                }
                catch(Exception $e){
                    return $e->getMessage();
                }
            }
        }
        return 'done';
    }

    private function SetCallReportValidate($request)
    {
        return date('Y-m-d');
    }

    public function GetCallReport($date)
    {
        $data = $this->model->where('created_at', 'like', "%$date%")->get()->each(function($raw){
        $max_unanswer_number = config('app.report.call.max_unanswer_number');   
            try{
                $raw->answer_eff = (int)($raw->answer_percent *100 / ($raw->answer_percent + $raw->unanswer_percent));
            }
            catch(DivisionByZeroError  $e){
                $raw->answer_eff = "بدون مقدار"; 
            }

            try{
                $a = $raw->answer_time / 60 * 8; // در هر دقیقه 8 بار مشغولی ثبت میشود
                $b = $raw->busy_percent * $raw->total / 100;
                $raw->busy_eff = (int)(($a - $b) / $a * 100);
            }
            catch(DivisionByZeroError $e){
                $raw->busy_eff = "بدون مقدار";
            }

            $raw->avg = (int)((int)$raw->answer_eff + (int)$raw->busy_eff) / 2;
            $raw->answer = [
                'number' => $raw->answer,
                'percent' => $raw->answer_percent
            ];
            $raw->unanswer = [
                'number' => $raw->unanswer,
                'percent' => $raw->unanswer_percent
            ];
            $raw->busy = [
                'number' => $raw->busy,
                'percent' => $raw->busy_percent
            ];


        });
        return $data;
    }

    public function SetCallReportFromExcel(Request $r)
    {
        $file = $r->file->move($this->report_dir, 'text.xlsx');
        if ($xlsx = SimpleXLSX::parse($file)) {
            $rows = $xlsx->rows();
            $counter = 0;
            // $data = [] ;
            for($i=1; $i < count($rows); $i++){
                if(isset($rows[$i+1]) and
                    $rows[$i][1] === $rows[$i+1][1] and 
                    $rows[$i][2] === $rows[$i+1][2] 
                ){
                    $counter++;
                }else{
                    if(strlen($rows[$i][1]) > 3 and
                        in_array($rows[$i][2], array_keys(config('app.report.call.extensions')))){
                        $data[] = $rows[$i];
                    }
                    $counter = 0;
                }
            }
            // return $data;
            $total = count($data);
            $result = [];
            foreach($data as $row){
                $result[$row[2]]['total'] = (isset($result[$row[2]]['total'])) ? $result[$row[2]]['total'] +1 : 1;
                switch($row[4]){
                    case 'بدون پاسخ':
                        $result[$row[2]]['unanswer'] = (isset($result[$row[2]]['unanswer'])) ? $result[$row[2]]['unanswer'] +1 : 1;
                        break;
                    case 'پاسخ داده شده':
                        $result[$row[2]]['answer'] = (isset($result[$row[2]]['answer'])) ? $result[$row[2]]['answer'] +1 : 1;
                        $result[$row[2]]['answer-time'] = (isset($result[$row[2]]['answer-time'])) ? 
                            $result[$row[2]]['answer-time'] + $this->convertTimeToSeconds($row[3]) :
                            $this->convertTimeToSeconds($row[3]);
                        break;
                    case 'مشغول':
                        $result[$row[2]]['busy'] = (isset($result[$row[2]]['busy'])) ? $result[$row[2]]['busy'] +1 : 1;
                        break;
                    default:
                        $result[$row[2]]['not-success'] = (isset($result[$row[2]]['not-success'])) ? $result[$row[2]]['not-success'] +1 : 1;
                        break;
                }
            }
            return $result;
        } 
    }

    public function convertTimeToSeconds($str_time)
    {
        sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

        return isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
    }


    public function upload_file($file, $file_name)
    {
        if(!file_exists($this->report_dir))
            mkdir($this->report_dir,0777,true);
        $file->move($this->report_dir, $file);
        return "$this->report_dir/$file_name";
    }

    public function get_number_of_issues()
    {
        return IssuesModel::count();
    }

    public function number_of_today_issues()
    {
        $today = Verta()->formatDate();
        return IssuesModel::where('created_at', 'like', "$today%")->count();
    }

    public function my_answered_issues()
    {
        return IssuesModel::where('who_answered', Auth::id())->count();
    }

    public function my_today_answered_issues()
    {
        $today = Verta()->formatDate();
        return IssuesModel::where('updated_at', 'like', "$today%")->where('who_answered', Auth::id())->count();
    }

    public function upload_license_request_excel(Request $request)
    {
        Access::check('report_license');
        try{
            $filename = 'LicenseRequest.xlsx';
            if(!file_exists($this->asnaf_report_dir))
                mkdir($this->asnaf_report_dir,0777,true);
            $file = $request->file('LicenseRequest');
            $file->move($this->asnaf_report_dir, $filename);
            return 'done';
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function upload_license_excel(Request $request)
    {
        Access::check('report_license');
        try{
            $filename = 'License.xlsx';
            if(!file_exists($this->asnaf_report_dir))
                mkdir($this->asnaf_report_dir,0777,true);
            $file = $request->file('License');
            $file->move($this->asnaf_report_dir, $filename);
            return 'done';
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function import_license_request_excel_to_db()
    {
        $this->license_req_model->get()->each(function($c){$c->delete();});
        $file = getcwd() . '/public/uploads/asnaf_report/LicenseRequest.xlsx';
        if ($xlsx = SimpleXLSX::parse($file)) {
            $i=0;
            foreach($xlsx->rows() as $row){
                try{
                    $this->license_req_model->insert([
                        'tracking_code' => $row[0],
                        'name' => $row[1],
                        'fname' => $row[2],
                        'request_date' => $row[4],
                        'request_type' => $row[5],
                        'status' => $row[9],
                        'province' => $row[10],
                    ]); 
                }catch(Exception $e){}
                $i++;
            }  
        } 
    }

    public function import_license_excel_to_db()
    {
        $this->license_model->get()->each(function($c){$c->delete();});
        $file = getcwd() . '/public/uploads/asnaf_report/License.xlsx';
        if ($xlsx = SimpleXLSX::parse($file)) {
            $i=0;
            foreach($xlsx->rows() as $row){
                try{
                    $this->license_model->insert([
                        'tracking_code' => $row[1],
                        'issued_date' => $row[8]
                    ]); 
                }catch(Exception $e){}
                $i++;
            }  
        } 
    }

    public function calculate_issued_request_diff_date()
    {
        Access::check('report_license');
        global $diff;
        $diff = [];

        $this->import_license_excel_to_db();
        $this->import_license_request_excel_to_db();

        $issued_time_avg_records = $this->license_req_model
        ->join('issued_license as il', 'il.tracking_code', 'issued_license_request.tracking_code')
        ->get()
        ->each(function($r){
            global $diff;
            $r->request_date = str_replace('/', '-', $r->request_date);
            $req_miladi = Verta::getGregorian($r->request_date);
            $req_carbon =  Carbon::createFromFormat('Y-m-d', $req_miladi);
            $miladi = Verta::getGregorian(str_replace('/', '-', $r->issued_date));
            $carbon =  Carbon::createFromFormat('Y-m-d', $miladi);
            $r->diff = $carbon->diffInDays($req_carbon);
            $r->request_date = str_replace('-', '/', $r->request_date);// FOR SHOWING IN EXCEL EXPORT IN DATATABLE
            $diff[]= $r->diff;
        });
        //return (count($diff)) ? array_sum($diff) / count($diff) : 'فایلهای ورودی بدرستی خوانده نشده است';

        $lrs = $this->license_req_model->get();
        $more_than_90_days = [];
        foreach($lrs as $lr){
            try{
                if( !in_array($lr->status, ['اعلام نظر قطعی - رد تقاضا', 'صدور پروانه کسب'])  ){
                    $request_date = str_replace('/', '-', $lr->request_date);
                    $req_miladi = Verta::getGregorian($request_date);
                    $req_carbon =  Carbon::createFromFormat('Y-m-d', $req_miladi);
                    $now_carbon =  Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
                    if($now_carbon->diffInDays($req_carbon) > 90){
                        $lr->diff = $now_carbon->diffInDays($req_carbon);
                        $more_than_90_days[] = $lr;
                    }
                }
            }
            catch(Exception $e){}
            
        }
        return [
            'issued_time_avg_records' => $issued_time_avg_records,
            'issued_time_avg' => (count($diff)) ? array_sum($diff) / count($diff) : 'فایلهای ورودی بدرستی خوانده نشده است',
            'more_than_90_days_non_issued_record' => $more_than_90_days 
        ];
    }
}