<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\MarakezModel;
use App\Models\ProvinceModel;
use App\Models\PelakkhanModel;
use File;
use App\CustomClasses\Access;
use App\CustomClasses\Date;
use App\Repository\RGenCode;
use Illuminate\Support\Facades\DB;
use App\Repository\RMarakez;
use Carbon\Carbon;
use Exception;
use Hekmatinasser\Verta\Verta;

class MarakezController extends Controller
{
    protected $RMarakez;
    private $RGenCode;
    private $msg;

    public function __construct()
    {
        $this->RMarakez = new RMarakez();
        $this->msg = new MessageController();
    }
    public function index($fin = null){
        Access::check('Marakez_index');
        $Marakez = DB::table('marakez1 as m')
                        ->leftjoin('pelakkhan as p', 'p.CodeEtehadie', 'm.CodeEtehadie')
                        ->select(
                            'm.*',
                            'p.Receiver',
                        )
                        ->get();
        $locks = PelakkhanModel::get();
        if($fin){
            return view('admin.marakez.fin-list', [
                'Marakez' => $Marakez,
                'locks' => $locks,
            ]);
        }
        return view('admin.marakez.marakez', [
            'Marakez' => $Marakez,
            'locks' => $locks,
        ]);
    }

    public function editmarkazform(Request $request, $id)
    {
        Access::check('Marakez_editmarkazform');
        $markaz = DB::table('marakez1 as m')
                        ->leftjoin('pelakkhan as p', 'p.CodeEtehadie', 'm.CodeEtehadie')
                        ->select(
                            'm.*',
                            'p.Receiver',
                            'p.code',
                            'p.Batch',
                            'p.PlateReader',
                            'p.DeliveryReceipts',
                            'p.updated_at as pdate'
                        )
                        ->where('m.id',$id)
                        ->first();
        //$lock = PelakkhanModel::where('CodeEtehadie', $markaz->CodeEtehadie)->first();

        return view('admin.marakez.editmarkaz', [
            'markaz' => $markaz,
            //'lock' => $lock,
        ]);

    }

    public function editmarkaz(Request $r,$id)
    {
        $markaz = MarakezModel::find($id);


        if( $r->input('FormType') == 'SodurForm' ){
            Access::check('Marakez_editmarkaz');

            $markaz = MarakezModel::find($id);

            $markaz->enable = isset($r->enable) ? 1 : 0;
            $markaz->NationalID = $r->NationalID;
            $markaz->Name = $r->Name;
            $markaz->Province = $r->Province;
            $markaz->City = $r->City;
            $markaz->CodeEtehadie = $r->CodeEtehadie;
            $markaz->ReceivingCodeYear = $r->ReceivingCodeYear;
            $markaz->GuildNumber = $r->GuildNumber;
            $markaz->IssueDate = $r->IssueDate;
            $markaz->ExpDate = $r->ExpDate;
            $markaz->PostalCode = $r->PostalCode;
            $markaz->Cellphone = $r->Cellphone;
            $markaz->Tel = $r->Tel;
            $markaz->Address = $r->Address;
            $markaz->Location = $r->Location;
            $markaz->Details = $r->Details;

            $InsUserDelivered = $r->input('InsUserDelivered');
            if(isset($InsUserDelivered))
            {
                $InsUserDelivered = 'ok';
            }else{
                $InsUserDelivered = 'not ok';
            }

            $markaz->InsUserDelivered = $InsUserDelivered;

            $file = $r->file( 'DeliveryReceipts' );
            if( !empty($file) )
            {
                $file_type = strtolower($file->getClientOriginalExtension());
                if($file->getSize() > 300000)
    	        {
    	            $error = "حجم فایل کمتر از 300 کیلوبایت";
                    return view('admin.marakez.editmarkaz', [
                        'error' => $error,
                        'markaz' => $markaz
                    ]);
    	        }

                if($file_type == 'jpg' || $file_type == 'png' || $file_type == 'jpeg')
                {
                    $path = 'public/marakez/' . $r->CodeEtehadie ;
                    $filename = rand(10000,99999). "." . strtolower($file->getClientOriginalExtension());
                    $markaz->DeliveryReceipts = $path .'/'. $filename ;
                    if(file_exists($path))
    	            {

    	            }else{
    	                File::makeDirectory( $path,0777,true );
    	            }
                    $file->move( $path, $filename );
                }else
                {
                    $error = "فقط فرمت jpg / png / jpeg";
                    return view('admin.marakez.editmarkaz', [
                        'error' => $error,
                        'markaz' => $markaz
                    ]);
                }
            }

            if($markaz->save()){
                $markaz->refresh();
                $message = "ویرایش شد.";
                return view('admin.marakez.editmarkaz', [
                    'message' => $message,
                    'markaz' => $markaz
                ]);
            }else{
                $error = "ناموفق";
                return view('admin.marakez.editmarkaz', [
                    'error' => $error,
                    'markaz' => $markaz
                ]);
            }
        }

        if( $r->input('FormType') == 'FinForm' ){
            Access::check('edit_fin_form');
            try
            {
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
                        $this->msg->send([18,25,37],'مرکز '.$markaz->CodeEtehadie. 'سبز شد. احتمالا باید در irngv فعال شود.');
                }

                if($markaz->FinGreen == 'ok'){
                    if($FinGreen == 'not ok')
                    $this->msg->send([18,25,37],'مرکز '.$markaz->CodeEtehadie. 'از حالت تسویه مالی خارج شد. احتمالا باید در irngv غیرفعال شود. برای اطمینان بیشتر با واحد مالی هماهنگ کنید.');
                }
    
                $update = MarakezModel::where('id', $id)->update([
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
                    return view('admin.marakez.editmarkaz', [
                        'message' => $message,
                        'markaz' => $markaz
                    ]);
                
            }
            catch(Exception $e){
                return view('admin.marakez.editmarkaz', [
                    'error' => $e->getMessage(),
                    'markaz' => $markaz
                ]);
            }
        }
    }

    public function addmarkazform()
    {
        Access::check('Marakez_addmarkazform');
        $Provinces = ProvinceModel::get();
        return view('admin.marakez.addmarkaz', [ 'Provinces' => $Provinces ]);
    }

    public function addmarkaz(Request $request)
    {
        Access::check('Marakez_addmarkaz');

        $markaz = new MarakezModel($request->all());
        $generator = new RGenCode($markaz->Province);
        $markaz->CodeEtehadie = $generator->Markaz();
        $markaz->save();

        $Provinces = ProvinceModel::get();
        $message = "ثبت شد. کد مرکز: $markaz->CodeEtehadie";
        return view('admin.marakez.addmarkaz', [ 'Provinces' => $Provinces , 'message' => $message ]);

    }

    public function addCodeYear()
    {
        $marakez = MarakezModel::get();

        foreach($marakez as $markaz)
        {
            if(strlen($markaz->GuildNumber) == 9 )
            {
                $m = '0' . $markaz->GuildNumber;
                MarakezModel::where('id', $markaz->id)->update([ 'GuildNumber' => $m ]);
                echo 'd';
            }
        }
    }

    public function EditPelakkhan(Request $request)
    {
        if(!is_null($this->RMarakez->EditPelakkhanValue($request)))
            return $this->RMarakez->EditPelakkhanValue($request);


        return redirect()->back();
    }

    public function getMarakez($code)
    {
        $marakez = MarakezModel::where('codeEtehadie','like', "$code%")->paginate(5);
        $options = '';
        foreach($marakez as $item){
            $options .= "<option value='$item->CodeEtehadie'>$item->CodeEtehadie - $item->Name - $item->Province</option>";
        }

        return $options;
    }

    public function checkMarkaz($nid, $mobile, $code){
        $markaz = MarakezModel::where('NationalID', $nid)->where('Cellphone', $mobile)->where('CodeEtehadie', $code)->first();
        if($markaz)
            return $markaz;
        
            $markaz = MarakezModel::where('NationalID', $nid)->where('CodeEtehadie', $code)->first();
        if($markaz && $markaz->Cellphone != $mobile)
            return 'شماره موبایل با شماره ثبت شده در سامانه اتحادیه مطابقت ندارد';
        
        $markaz = MarakezModel::where('NationalID', $nid)->where('Cellphone', $mobile)->first();
        if($markaz && $markaz->CodeEtehadie != $code)
            return 'کد مرکز مربوط به این کد ملی نیست';
        
        $markaz = MarakezModel::where('NationalID', $nid)->first();
        if(!$markaz)
            return 'کدملی یافت نشد';
    }

    public function get_all()
    {
        return MarakezModel::get();
    }

    public function get_fin_info($id)
    {
        return MarakezModel::find($id);
    }

    public function edit_fin_info(Request $r, $id)
    {
        $markaz = MarakezModel::find($id);
        try{
            $FinGreen = $r->FinGreen;
            if(isset($FinGreen))
            {
                $FinGreen = 'ok';
            }else{
                $FinGreen = 'not ok';
            }

            if($markaz->FinGreen == null || $markaz->FinGreen == 'not ok'){
                if($FinGreen == 'ok')
                    $this->msg->send([18,25,37],'مرکز '.$markaz->CodeEtehadie. 'سبز شد. احتمالا باید در irngv فعال شود.');
            }

            if($markaz->FinGreen == 'ok'){
                if($FinGreen == 'not ok')
                $this->msg->send([18,25,37],'مرکز '.$markaz->CodeEtehadie. 'از حالت تسویه مالی خارج شد. احتمالا باید در irngv غیرفعال شود. برای اطمینان بیشتر با واحد مالی هماهنگ کنید.');
            }

            $update = MarakezModel::where('id', $id)->update([
                'MembershipFee96' => $r->MembershipFee96,
                'MembershipFee96_PayDate' => $r->MembershipFee96_PayDate,
                'MembershipFee96_Refid' => $r->MembershipFee96_Refid,
                'MembershipFee97' => $r->MembershipFee97,
                'MembershipFee97_PayDate' => $r->MembershipFee97_PayDate,
                'MembershipFee97_Refid' => $r->MembershipFee97_Refid,
                'MembershipFee98' => $r->MembershipFee98,
                'MembershipFee98_PayDate' => $r->MembershipFee98_PayDate,
                'MembershipFee98_Refid' => $r->MembershipFee98_Refid,
                'MembershipFee99' => $r->MembershipFee99,
                'MembershipFee99_PayDate' => $r->MembershipFee99_PayDate,
                'MembershipFee99_Refid' => $r->MembershipFee99_Refid,
                'Membership00' => $r->Membership00,
                'Membership00_PayDate' => $r->Membership00_PayDate,
                'Membership00_Refid' => $r->Membership00_Refid,
                'Membership01' => $r->Membership01,
                'Membership01_PayDate' => $r->Membership01_PayDate,
                'Membership01_Refid' => $r->Membership01_Refid,
                'debt' => $r->debt,
                'debt_description' => $r->debt_description,
                'LockFee' => $r->LockFee,
                'LockFee_PayDate' => $r->LockFee_PayDate,
                'LockFee_Refid' => $r->LockFee_Refid,
                'IrngvFee' => $r->IrngvFee,
                'IrngvFee_PayDate' => $r->IrngvFee_PayDate,
                'IrngvFee_Refid' => $r->IrngvFee_Refid,
                'FinGreen' => $FinGreen,
                'FinDetails' => $r->FinDetails,
            ]);

            return response('ویرایش شد');
            
        }
        catch(Exception $e){
            return response('خطا: ' . $e->getMessage());
        }
    }

    public function edit_markaz_info(Request $r, $id)
    {
        try{
            Access::check('Marakez_editmarkaz');

            $markaz = MarakezModel::find($id);

            $markaz->enable = isset($r->enable) ? 1 : 0;
            $markaz->NationalID = $r->NationalID;
            $markaz->Name = $r->Name;
            $markaz->Province = $r->Province;
            $markaz->City = $r->City;
            $markaz->CodeEtehadie = $r->CodeEtehadie;
            $markaz->ReceivingCodeYear = $r->ReceivingCodeYear;
            $markaz->GuildNumber = $r->GuildNumber;
            $markaz->IssueDate = $r->IssueDate;
            $markaz->ExpDate = $r->ExpDate;
            $markaz->PostalCode = $r->PostalCode;
            $markaz->Cellphone = $r->Cellphone;
            $markaz->Tel = $r->Tel;
            $markaz->Address = $r->Address;
            $markaz->Location = $r->Location;
            $markaz->Details = $r->Details;

            $markaz->InsUserDelivered = isset($r->InsUserDelivered) ? 'ok' : 'not ok';
            $markaz->save();
            return response('ویرایش شد');
        }
        catch(Exception $e){
            return response('خطا: '. $e->getMessage());
        }

            
    }


    public function createApi()
    {
        $now = Verta();
        $m = MarakezModel::whereNotNull( 'CodeEtehadie' )
        ->whereNotNull('ExpDate')
        ->where( 'GuildNumber', '!=', '' )
        ->where('enable', 1)
        ->orderBy( 'CodeEtehadie' )
        ->select('Name', 'Province', 'City', 'CodeEtehadie', 'GuildNumber', 'Address', 'IssueDate', 'ExpDate')
        ->get();
        
        $data = [];
        foreach($m as $m){
            $m->ExpDate = Date::toArray($m->ExpDate);
            $m->ExpDate = Verta::jalaliToGregorian($m->ExpDate[0], $m->ExpDate[1], $m->ExpDate[2]);
            $m->ExpDate = Date::gregorianToCarbon($m->ExpDate);
            $now_carbon = Carbon::now();
            $m->diff = $now_carbon->diffInDays($m->ExpDate, false);
            if($m->diff >= 0){
                $data[] = $m;
            }
        }
        return $data;
    }
}
