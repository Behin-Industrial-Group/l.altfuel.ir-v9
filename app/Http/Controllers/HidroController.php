<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\HidroModel;
use App\Models\ProvinceModel;
use App\CustomClasses\Access;
use App\CustomClasses\Date;
use App\Repository\RGenCode;
use Carbon\Carbon;
use Exception;
use File;
use Hekmatinasser\Verta\Verta;


class HidroController extends Controller
{
    private $msg;

    public function __construct()
    {
        $this->msg = new MessageController();
    }
    public function index()
    {
        Access::check('Hidro_index');
        $Marakez = HidroModel::orderBy('CodeEtehadie')->get();
        return view('admin.hidro', [
            'Marakez' => $Marakez
        ]);
    }

    public function show($id)
    {
        $markaz = HidroModel::where('id', $id)->first();

        return view('admin.edithidro', [
            'markaz' => $markaz
        ]);
    }

    public function show_fin_form_view(Request $r)
    {
        $marakesz = HidroModel::get();
        return view('admin.hidro.fin-list')->with([
            'Marakez' => $marakesz,
        ]);
    }

    public function get_all()
    {
        return HidroModel::get();
    }

    public function get_fin_info($id)
    {
        return HidroModel::find($id);
    }

    public function edit_fin_info(Request $r, $id)
    {
        Access::check('Hidro_edit_fin_info');
        try{
            HidroModel::where('id', $id)->update($r->all());
            HidroModel::where('id', $id)->update([
                'FinGreen' => ($r->FinGreen) ? 'ok' : 'not ok',
            ]);


            return response('ویرایش شد');
            
        }
        catch(Exception $e){
            return response('خطا: ' . $e->getMessage());
        }
    }

    public function edit_markaz_info(Request $r, $id)
    {
        Access::check('Hidro_editmarkaz');
        try{
            HidroModel::where('id', $id)->update($r->all());
            
            return response('ویرایش شد');
        }
        catch(Exception $e){
            return response('خطا: '. $e->getMessage());
        }

            
    }

    public function edit(Request $r, $id)
    {

        Access::check('Hidro_editmarkaz');
        $markaz = HidroModel::find($id);

        if( $r->input('FormType') == 'SodurForm' ){

            $hidro = HidroModel::find($id);

            $hidro->NationalID = $r->NationalID;
            $hidro->Name = $r->Name;
            $hidro->Province = $r->Province;
            $hidro->City = $r->City;
            $hidro->CodeEtehadie = $r->CodeEtehadie;
            $hidro->ReceivingCodeYear = $r->ReceivingCodeYear;
            $hidro->GuildNumber = $r->GuildNumber;
            $hidro->IssueDate = $r->IssueDate;
            $hidro->ExpDate = $r->ExpDate;
            $hidro->PostalCode = $r->PostalCode;
            $hidro->Cellphone = $r->Cellphone;
            $hidro->Tel = $r->Tel;
            $hidro->Address = $r->Address;
            $hidro->Location = $r->Location;
            $hidro->Details = $r->Details;
            $hidro->enable = isset($r->enable) ? 1 : 0;

            $file = $r->file( 'DeliveryReceipts' );
            if( !empty($file) )
            {
                $file_type = strtolower($file->getClientOriginalExtension());
                if($file->getSize() > 300000)
    	        {
    	            $error = "حجم فایل کمتر از 300 کیلوبایت";
                    return view('admin.marakez.editmazrkaz', [
                        'error' => $error,
                        'markaz' => $hidro
                    ]);
    	        }

                if($file_type == 'jpg' || $file_type == 'png' || $file_type == 'jpeg')
                {
                    $path = 'public/marakez/' . $r->CodeEtehadie ;
                    $filename = rand(10000,99999). "." . strtolower($file->getClientOriginalExtension());
                    $hidro->DeliveryReceipts = $path .'/'. $filename ;
                    if(file_exists($path))
    	            {

    	            }else{
    	                File::makeDirectory( $path,0777,true );
    	            }
                    $file->move( $path, $filename );
                }else
                {
                    $error = "فقط فرمت jpg / png / jpeg";
                    return view('admin.marakez.editmazrkaz', [
                        'error' => $error,
                        'markaz' => $hidro
                    ]);
                }
            }

            if($hidro->save()){
                $hidro->refresh();
                $message = "ویرایش شد.";
                return view('admin.edithidro', [
                    'message' => $message,
                    'markaz' => $hidro
                ]);
            }else{
                $error = "ناموفق";
                return view('admin.edithidro', [
                    'error' => $error,
                    'markaz' => $hidro
                ]);
            }
        }

        if( $r->input('FormType') == 'FinForm' ){
            Access::check('edit_fin_form');
            $MembershipFee96 = $r->input('MembershipFee96');
            $MembershipFee96_PayDate = $r->input('MembershipFee96_PayDate');
            $MembershipFee96_Refid = $r->input('MembershipFee96_Refid');
            $MembershipFee97 = $r->input('MembershipFee97');
            $MembershipFee97_PayDate = $r->input('MembershipFee97_PayDate');
            $MembershipFee97_Refid = $r->input('MembershipFee97_Refid');
            $MembershipFee98 = $r->input('MembershipFee98');
            $MembershipFee98_PayDate = $r->input('MembershipFee98_PayDate');
            $MembershipFee98_Refid = $r->input('MembershipFee98_Refid');
            $MembershipFee99 = $r->input('MembershipFee99');
            $MembershipFee99_PayDate = $r->input('MembershipFee99_PayDate');
            $MembershipFee99_Refid = $r->input('MembershipFee99_Refid');
            $MembershipFee00 = $r->input('Membership00');
            $MembershipFee00_PayDate = $r->input('Membership00_PayDate');
            $MembershipFee00_Refid = $r->input('Membership00_Refid');
            $MembershipFee01 = $r->input('Membership01');
            $MembershipFee01_PayDate = $r->input('Membership01_PayDate');
            $MembershipFee01_Refid = $r->input('Membership01_Refid');
            $debt = $r->input('debt');
            $debt_description = $r->input('debt_description');
            $LockFee = $r->input('LockFee');
            $LockFee_PayDate = $r->input('LockFee_PayDate');
            $LockFee_Refid = $r->input('LockFee_Refid');
            $IrngvFee_PayDate = $r->input('IrngvFee_PayDate');
            $IrngvFee_Refid = $r->input('IrngvFee_Refid');
            $IrngvFee = $r->input('IrngvFee');
            $FinDetails = $r->input('FinDetails');

            $FinGreen = $r->input('FinGreen');
            if(isset($FinGreen))
            {
                $FinGreen = 'ok';
            }else{
                $FinGreen = 'not ok';
            }

            if($markaz->FinGreen == null || $markaz->FinGreen == 'not ok'){
                if($FinGreen == 'ok')
                    $this->msg->send([18,25,37],'هیدرو '.$markaz->CodeEtehadie. 'سبز شد. احتمالا باید در irngv فعال شود.');
            }

            if($markaz->FinGreen == 'ok'){
                if($FinGreen == 'not ok')
                $this->msg->send([18,25,37],'هیدرو '.$markaz->CodeEtehadie. 'از حالت تسویه مالی خارج شد. احتمالا باید در irngv غیرفعال شود. برای اطمینان بیشتر با واحد مالی هماهنگ کنید.');
            }

            try{
                HidroModel::where('id', $id)->update([
                    'MembershipFee96' => $MembershipFee96,
                    'MembershipFee96_PayDate' => $MembershipFee96_PayDate,
                    'MembershipFee96_Refid' => $MembershipFee96_Refid,
                    'MembershipFee97' => $MembershipFee97,
                    'MembershipFee97_PayDate' => $MembershipFee97_PayDate,
                    'MembershipFee97_Refid' => $MembershipFee97_Refid,
                    'MembershipFee98' => $MembershipFee98,
                    'MembershipFee98_PayDate' => $MembershipFee98_PayDate,
                    'MembershipFee98_Refid' => $MembershipFee98_Refid,
                    'MembershipFee99' => $MembershipFee99,
                    'MembershipFee99_PayDate' => $MembershipFee99_PayDate,
                    'MembershipFee99_Refid' => $MembershipFee99_Refid,
                    'Membership00' => $MembershipFee00,
                    'Membership00_PayDate' => $MembershipFee00_PayDate,
                    'Membership00_Refid' => $MembershipFee00_Refid,
                    'Membership01' => $MembershipFee01,
                    'Membership01_PayDate' => $MembershipFee01_PayDate,
                    'Membership01_Refid' => $MembershipFee01_Refid,
                    'debt' => $debt,
                    'debt_description' => $debt_description,
                    'LockFee' => $LockFee,
                    'LockFee_PayDate' => $LockFee_PayDate,
                    'LockFee_Refid' => $LockFee_Refid,
                    'IrngvFee' => $IrngvFee,
                    'IrngvFee_PayDate' => $IrngvFee_PayDate,
                    'IrngvFee_Refid' => $IrngvFee_Refid,
                    'FinGreen' => $FinGreen,
                    'FinDetails' => $FinDetails,
                ]);
                $markaz->refresh();
                $message = "ویرایش شد.";
                return view('admin.edithidro', [
                    'message' => $message,
                    'markaz' => $markaz
                ]);
            }
            catch(Exception $e){
                $error = "ناموفق";
                return view('admin.edithidro', [
                    'error' => $e,
                    'markaz' => $markaz
                ]);
            }
        }

    }

    public function addform()
    {
        Access::check('Hidro_addform');

        $Provinces = ProvinceModel::get();
        return view('admin.addhidro', [ 'Provinces' => $Provinces ]);
    }

    public function addmarkaz(Request $request)
    {
        Access::check('Hidro_addmarkaz');

        $markaz = new HidroModel($request->all());
        $generator = new RGenCode($markaz->Province);
        $markaz->CodeEtehadie = $generator->Hidro();
        $markaz->save();

        $Provinces = ProvinceModel::get();
        $message = "ثبت شد. کد مرکز: $markaz->CodeEtehadie";
        return view('admin.addhidro', [ 'Provinces' => $Provinces , 'message' => $message ]);

    }
    public function checkMarkaz($nid, $mobile, $guildNumber)
    {
        $markaz = HidroModel::where('NationalID', $nid)->first();
        if(!$markaz)
            return "مرکز هیدرواستاتیکی  با این کدملی وجود ندارد.";
        if($markaz->Cellphone != $mobile)
            return "شماره موبایل با شماره ثبت شده در سامانه مطابقت ندارد.";
        if($markaz->CodeEtehadie != $guildNumber)
            return " کد مرکز وارد شده صحیح نمی باشد";
        return $markaz;
    }

    public function createApi()
    {
        $hidros = HidroModel::whereNotNull( 'CodeEtehadie' )
        ->whereNotNull('ExpDate')
        ->where( 'GuildNumber', '!=', '' )
        ->where('enable', 1)
        ->orderBy( 'CodeEtehadie' )
        ->select('Name', 'Province', 'City', 'CodeEtehadie', 'GuildNumber', 'Address', 'Tel', 'IssueDate', 'ExpDate')
        ->get();

        $data = [];
        foreach($hidros as $m){
            $m->ExpDate = Date::toArray($m->ExpDate);
            $m->GregorianExpDate = Verta::jalaliToGregorian($m->ExpDate[0], $m->ExpDate[1], $m->ExpDate[2]);
            $m->GregorianExpDate = Date::gregorianToCarbon($m->GregorianExpDate);
            $now_carbon = Carbon::now();
            $m->diff = $now_carbon->diffInDays($m->GregorianExpDate, false);
            if($m->diff >= 0){
                $data[] = $m;
            }
        }
        return $data;

        return $hidros;
    }
}
