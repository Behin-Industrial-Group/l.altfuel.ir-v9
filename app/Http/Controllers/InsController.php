<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\IssuesModel;
use App\Models\IssuesCatagoryModel;
use App\Models\MarakezModel;
use App\Models\VideosModel;
use App\Models\VideosCatagoriesModel;
use App\Models\AsignInsModel;
use File;
use Verta;
use App\Traits\reCAPTCHA;
use App\CustomClasses\IssuesCatagory;
use App\CustomClasses\Logs;
use App\CustomClasses\Access;
use SoapClient;
use App\Enums\EnumsEntity as Enum;
use Illuminate\Support\Facades\Auth;
use Mkhodroo\AgencyInfo\Controllers\GetAgencyController;

class InsController extends Controller
{
    private $model;

    public function __construct() {
        $this->model = new AsignInsModel();
    }
    public function asignInsForm($message = null, $error = null)
    {
        $marakez = MarakezModel::whereNotNull("CodeEtehadie")->get();
        return view("admin.ins.asignInsForm")->with([ 'message' => $message, 'error' => $error, 'marakez' => $marakez ]);
    }

    public function asignIns(Request $r)
    {
        if(!is_null($this->Validation($r))){
            $error = $this->Validation($r);
            return $this->asignInsForm(null,$error);
        }

        $this->asignInsSetValues($r);
        $message = "ثبت شد";
        return $this->asignInsForm($message);

    }

    private function asignInsSetValues($r)
    {
        try{
            $asignInsRequest = new AsignInsModel();

            $asignInsRequest->insCo = Auth::user()->id;
            $asignInsRequest->type = $r->type;
            if(Enum::$RequestType[$r->type] == Enum::$RequestType['remove']){
                $old_reuqest = $this->model->where('ins_nationalId', $r->nationalId)->first();
                $asignInsRequest->ins_fname = $old_reuqest->ins_fname;
                $asignInsRequest->ins_lname = $old_reuqest->ins_lname;
                $asignInsRequest->ins_nationalId = $old_reuqest->ins_nationalId;
                $asignInsRequest->markaz_code = $old_reuqest->markaz_code;

            }else{
                $asignInsRequest->ins_fname = $r->fname;
                $asignInsRequest->ins_lname = $r->lname;
                $asignInsRequest->ins_nationalId = $r->nationalId;
                $asignInsRequest->ins_cellphone = $r->cellphone;
                $asignInsRequest->markaz_code = $r->codeEtehadie;
                $asignInsRequest->ins_description = $r->ins_description;
            }
            $asignInsRequest->save();
        }
        catch(\Exception $e){
            $error = "ناموفق - تمامی فیلدها اجباری است";
            return $this->asignInsForm(null,$e->getMessage());
        }

    }

    public function asignInsList()
    {
        $asignInsRequest = AsignInsModel::where("insCo", Auth::user()->id)->get();
        return view("admin.ins.asignInsList")->with([ 'asignInsRequest' => $asignInsRequest ]);
    }

    public function Validation($request){
        if(is_null($request->type)){
            return "نوع درخواست نباید خالی باشد";
        }
        if($this->isValidIranianNationalCode($request->nationalId) == false)
        {
            return "کدملی معتبر نیست";
        }

        if($request->type == 'remove'){
            $a = AsignInsModel::where('ins_nationalId', $request->nationalId)->where('asign', '1')->first();
            if(!is_null($a)){
                if($a->insCo != Auth::user()->id){
                    return "شما برای این بازرس نمیتوانید درخواست حذف ثبت نمایید";
                }
            }

            $a = AsignInsModel::where('ins_nationalId', $request->nationalId)->where('asign', '0')->where('type', 'remove')->first();
            if($a){
                return "شما یک درخواست حذف قبلا برای این بازرس ثبت کرده اید که هنوز تعیین تکلیف نشده است";
            }
        }


        if($request->type == 'asign'){
            $ins = AsignInsModel::where('ins_nationalId', $request->nationalId)->where('asign', '1')->first();
            if(!is_null($ins)){
                return "این کد ملی در کارگاه $ins->markaz_code تخصیص داده شده است";
            }
            $g = GetAgencyController::getByKeyValue('agency_code', $request->codeEtehadie);
            $agency_code = $g->agency_code;
            $guild_number = $g->guild_number;
            if(!$agency_code){
                return "این کد مرکز وجود ندارد ";
            }

            if(is_null($guild_number) || empty($guild_number)){
                return "این مرکز شناسه صنفی ندارد / شناسه صنفی این مرکز در سامانه ثبت نشده است";
            }

            // $markaz = MarakezModel::where('CodeEtehadie', $request->codeEtehadie)->where('FinGreen', '!=', "ok")->first();
            // if(!is_null($markaz)){
            //     return "تسویه مالی این کارگاه در سامانه ثبت نشده است. ابتدا مرکز باید با بخش مالی اتحادیه هماهنگ کند";
            // }

            $markaz = AsignInsModel::where('markaz_code', $agency_code)->where('asign', '1')->first();
            if(!is_null($markaz)){
                return "برای این مرکز قبلا بازرس تخصیص داده شده است";
            }
        }

        return null;
    }


    private function isValidIranianNationalCode($input) {
        if (!preg_match("/^\d{10}$/", $input)) {
            return false;
        }

        $check = (int) $input[9];
        $sum = array_sum(array_map(function ($x) use ($input) {
            return ((int) $input[$x]) * (10 - $x);
        }, range(0, 8))) % 11;

        return ($sum < 2 && $check == $sum) || ($sum >= 2 && $check + $sum == 11);
    }

    public function GetNids($nid)
    {
        $ins = AsignInsModel::where('ins_nationalId','like', "%$nid%")->where('type', 'asign')->paginate(5);
        $options = "";
        foreach($ins as $ins){
            $options .= "<option value='$ins->ins_nationalId'>$ins->ins_fname $ins->ins_lname</option>";
        }
        return $options;
    }

    public function GetData($column, $value)
    {
        return AsignInsModel::where("ins_nationalId", "$value")->first()->$column;
    }
}
