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
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RReport
{
    protected $model;
    private $license_req_model;
    private $license_model;
    private $asnaf_report_dir;

    public function __construct()
    {
        $this->model = new Call();
        $this->license_model = new License();
        $this->license_req_model = new LicenseRequest();
        $this->asnaf_report_dir = 'public/uploads/asnaf_report';
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
        return json_encode($this->model->where('created_at', 'like', "%$date%")->get());
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