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
use Auth;
use App\Traits\reCAPTCHA;
use App\CustomClasses\IssuesCatagory;
use App\CustomClasses\Logs;
use App\CustomClasses\Access;
use SoapClient;


class RequestController extends Controller
{
    public function asignInsList($id=0)
    {
        if($id == 'all'){
            $asignInsRequest = AsignInsModel::join("users", "users.id", "asignInsRequest.insCo")->select('users.display_name','asignInsRequest.*')->orderBy('id','desc')->get();
        }else{
            $asignInsRequest = AsignInsModel::join("users", "users.id", "asignInsRequest.insCo")->select('users.display_name','asignInsRequest.*')->orderBy('id','desc')->where('asign', $id)->get();
        }

        return view("admin.request.asignInsList")->with([ "asignInsRequest" => $asignInsRequest]);
    }

    public function asignInsEditForm($markaz_code, $message =null, $error = null)
    {
        $asignInsRequest = AsignInsModel::join("users", "users.id", "asignInsRequest.insCo", 'right outer')
                                            ->where("markaz_code",'LIKE', "%$markaz_code%")
                                            ->orderby('asignInsRequest.id')
                                            ->select('users.display_name','asignInsRequest.*')
                                            ->get();
        return view("admin.request.asignInsEditForm")->with([ 'message' => $message, 'error' => $error, "asignInsRequest" => $asignInsRequest]);
    }

    public function asignInsEdit(Request $r, $id)
    {
        $markaz_code = AsignInsModel::where("id", $id)->first()->markaz_code;
        if($this->Validation($r,$id)){
            $error =  $this->Validation($r,$id);
            return $this->asignInsEditForm($markaz_code, null, $error);
        }
        try
        {
            $this->asignInsEditValue($r,$id);
            $message = "ثبت شد";
            return $this->asignInsEditForm($markaz_code, $message);
        }
        catch(\Exception $e)
        {
            $error = "عملیات ناموفق";
            return $this->asignInsEditForm($markaz_code, null, $error);
        }

    }

    private function asignInsEditValue($r, $id)
    {
        $edit =AsignInsModel::find($id);
        $edit->status = 1;
        $edit->asign = $r->asign;
        $edit->description = $r->description;
        $edit->comment = $r->comment;

        $edit->save();

    }

    private function Validation($request, $id)
    {
        $ins_req = AsignInsModel::where('id', $id)->first();
        if(AsignInsModel::where('markaz_code', $ins_req->markaz_code)
                        ->where('id', '!=', $id)
                        ->where('asign', '1')
                        ->count()  &&
                        $request->asign == 1){
            return "این مرکز بازرس فعال دارد";
        }

        return null;
    }
}
