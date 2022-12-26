<?php

namespace App\Repository;

use App\CustomClasses\IssuesCatagory;
use App\CustomClasses\Logs;
use App\CustomClasses\Marakez;
use App\Models\IssuesModel;
use App\Models\RelatedIssueModel;
use Illuminate\Support\Str;
use App\Enums\EnumsEntity as Enum;
use App\Models\HidroModel;
use App\Models\IssuesCatagoryModel;
use App\Models\MarakezModel;
use Exception;
use File;

class RIssue{
    protected $model;
    private $RMethod;

    public function __construct()
    {
        $this->model = new IssuesModel();
        $this->RMethod = new RMethod();
    }

    public function GetIssues($catagory,$tracking=null)
    {
        if($catagory == 'irngvagancy'){
            $issues = $this->model->select('issues.id', 'issues.name', 'issues.NationalID','issues.catagory', 'issues.issue', 'issues.status', 'issues.trackinglater', 'issues.updated_at')
                ->Join('marakez1', 'marakez1.NationalID', 'issues.NationalID')->where('issues.catagory', 'irngv')->orderBy('status')->orderBy('issues.id','desc')->get();
        }
        elseif($tracking == 'tracking-later'){
            $issues = $this->model->where('catagory', $catagory)->where('trackinglater', 'yes')->orderBy('status')->orderBy('id','desc')->get();
        }
        else{
            $issues = $this->model->where('catagory', $catagory)->orderBy('status')->get();
        }

        $i=0;
        foreach($issues as $r){
            $data = array();
            $data[] = $i;
            $data[] = $r->id;
            $data[] = $r->name;
            $data[] = $r->cellphone;
            if($r->trackinglater == 'yes'){
                $data[] = "<span dir='ltr' class='pull-center badge bg-red'>$r->updated_at</span>";
            }else{
                $data[] = "<span >$r->updated_at</span>";
            }
            $data[] = Str::limit($r->issue,85);
            $data[] = Enum::$IssueStatusType[$r->status];
            $data[] = "<a target='_blank' href='". Url("admin/issues/show/$r->catagory/national-id/$r->NationalID/#issue_$r->id") .  "'><i class='fa fa-edit' style='font-size:20px'></a>";
            $d[] = $data;
            $i++;
        }
        $output = array(
            'data' => $d
        );
        return $output;
    }

    public function SetNewCatagory($r)
    {
        try{
            $row = IssuesModel::find($r->id);
            $old_catagory = $row->catagory;

            $row->catagory = $r->catagory;
            $row->updated_at = Verta();
            $row->save();

            Logs::create('update', 'issues',
                $r->id,
                'catagory',
                "catagory: $r->catagory");

            return 'done';
        }
        catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function CreateNewIssue($request)
    {
        $issue = new IssuesModel($request->all());
        $file = $request->file('attach');

        if(!empty($file))
        {
            if($file->getSize() > 600000)
            {
                return 'حجم فایل بیش از600 کیلو بایت است';
            }

            $file_type = strtolower($file->getClientOriginalExtension());
            $valid_file_type = array('jpg','png','jpeg','pdf','xlsx','xls');
            if(in_array($file_type,$valid_file_type))
            {
                $path = 'public/uploads/' . $request->input('cellphone') ;
                $filename = rand(10000,99999). "." . strtolower($file->getClientOriginalExtension());

                $issue->file =  $path .'/'. $filename ;

                if(!file_exists($path))
                {
                    File::makeDirectory( $path,0777,true );
                }
                $file->move( $path, $filename );

            }else{
                return 'فرمت فایل باید jpg, png, jpeg باشد';
            }
        }
        try{
            $Date = Verta();
            $issue->answer = $request->answer;
            $issue->created_at = $Date;
            $issue->updated_at = $Date;
            $issue->status = 1;
            $issue->save();
            Logs::create('create', 'issues', $issue->id, 'name,NationalID,cellphone,issue,answer',
                "name: $request->name - NationalID: $request->NationalID - cellphone: $request->cellphone - issue: $request->issue - answer: $request->answer");

                return 'done';
        }
        catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function GetIssueNo($no)
    {
        $numbers = IssuesModel::where('id','like', "%$no%")->paginate(5);
        $options = "";
        foreach($numbers as $num){
            $text = Str::limit($num->issue,25);
            $options .= "<option value='$num->id'>$num->name - $text</option>";
        }
        return $options;
    }

    public function SetRelatedIssue($request, $issue_id)
    {
        try{
            $related = new RelatedIssueModel();
            $related->issue_id = $issue_id;
            $input_name = "issue_number_$issue_id";
            $related->related_issue_id = $request->$input_name;
            $related->save();
            return 'done';
        }
        catch(Exception $e){
            return $e->getMessage();
        }

    }

    public function SetSurvay($id)
    {

    }

    public function nid_is_markaz($nid)
    {
        $m = MarakezModel::where('NationalID', $nid)->count();
        if ($m>0) 
            return true;

        $h = HidroModel::where('NationalID', $nid)->count();
        if ($h>0) 
            return true;
        return false;
    }

    public function cellphone_is_not_for_markaz_nid($nid,$cellphone)
    {
        $m = MarakezModel::where('NationalID', $nid)->where('Cellphone', $cellphone)->count();
        if($m>0)
            return false;

        $h = HidroModel::where('NationalID', $nid)->where('Cellphone', $cellphone)->count();
        if($h>0)
            return false;

        return 'کد ملی شما بعنوان مرکز خدمات یا هیدرواستاتیک ثبت شده و شماره همراهی که وارد کرده اید با کدملی مطابقت ندارد';
    }

    public function add_catagory($r)
    {
        IssuesCatagoryModel::insert([
            'name'=> $r->name,
            'fa_name' => $r->fa_name,
            'catagory' => $r->catagory
        ]);
        $this->RMethod->add_method("Issues_$r->name"."_show", "تیکتها - مشاهده $r->fa_name");
    }
}
