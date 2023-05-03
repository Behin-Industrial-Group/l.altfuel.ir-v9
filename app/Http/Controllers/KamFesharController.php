<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\KamFesharModel;
use App\Models\ProvinceModel;
use App\CustomClasses\Access;
use Exception;
use File;

class KamFesharController extends Controller
{
    public function index()
    {
        $Marakez = KamFesharModel::orderBy('CodeEtehadie')->get();
        return view('admin.kamFeshar.marakez', [
            'Marakez' => $Marakez,
        ]);
    }

    public function show($id)
    {
        $markaz = KamFesharModel::where('id', $id)->first();

        return view('admin.kamFeshar.edit', [
            'markaz' => $markaz
        ]);
    }

    public function edit(Request $r, $id)
    {


        $markaz = KamFesharModel::find($id);

        if( $r->input('FormType') == 'SodurForm' ){
            $hidro = KamFesharModel::find($id);

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
                    return view('admin.kamFeshar.editmarkaz', [
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
                    return view('admin.kamFeshar.editmarkaz', [
                        'error' => $error,
                        'markaz' => $hidro
                    ]);
                }
            }

            if($hidro->save()){
                $hidro->refresh();
                $message = "ویرایش شد.";
                return view('admin.kamFeshar.editmarkaz', [
                    'message' => $message,
                    'markaz' => $hidro
                ]);
            }else{
                $error = "ناموفق";
                return view('admin.kamFeshar.editmarkaz', [
                    'error' => $error,
                    'markaz' => $hidro
                ]);
            }
        }

        if( $r->input('FormType') == 'FinForm' ){
            if(Gate::allows('Level3')):
            else:
                abort(403);
            endif;
            $MembershipFee96 = $r->input('MembershipFee96');
            $MembershipFee97 = $r->input('MembershipFee97');
            $MembershipFee98 = $r->input('MembershipFee98');
            $MembershipFee99 = $r->input('MembershipFee99');
            $MembershipFee00 = $r->input('MembershipFee00');
            $IrngvFee = $r->input('IrngvFee');
            $FinDetails = $r->input('FinDetails');

            $FinGreen = $r->input('FinGreen');
            if(isset($FinGreen))
            {
                $FinGreen = 'ok';
            }else{
                $FinGreen = 'not ok';
            }

            $update = KamFesharModel::where('id', $id)->update([
                'MembershipFee96' => $MembershipFee96,
                'MembershipFee97' => $MembershipFee97,
                'MembershipFee98' => $MembershipFee98,
                'MembershipFee99' => $MembershipFee99,
                'Membership00' => $MembershipFee00,
                'IrngvFee' => $IrngvFee,
                'FinGreen' => $FinGreen,
                'FinDetails' => $FinDetails,
            ]);

            $markaz->refresh();

            if($update){
                $message = "ویرایش شد.";
                return view('admin.kamFeshar.editmarkaz', [
                    'message' => $message,
                    'markaz' => $markaz
                ]);
            }else{
                $error = "ناموفق";
                return view('admin.kamFeshar.editmarkaz', [
                    'error' => $error,
                    'markaz' => $markaz
                ]);
            }
        }

    }

    public function show_fin_from_view(Request $r)
    {
        $marakesz = KamFesharModel::get();
        return view('admin.kamFeshar.fin-list')->with([
            'Marakez' => $marakesz,
        ]);
    }

    public function get_all()
    {
        return KamFesharModel::get();
    }

    public function get_fin_info($id)
    {
        return KamFesharModel::find($id);
    }

    public function edit_fin_info(Request $r, $id)
    {
        Access::check('KamFeshar_edit_fin_info');
        try{
            KamFesharModel::where('id', $id)->update($r->all());
            KamFesharModel::where('id', $id)->update([
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
        Access::check('KamFeshar_edit_markaz_info');
        try{
            KamFesharModel::where('id', $id)->update($r->all());
            
            return response('ویرایش شد');
        }
        catch(Exception $e){
            return response('خطا: '. $e->getMessage());
        }

            
    }


    public function addform()
    {
        Access::check('Hidro_addform');

        $Provinces = ProvinceModel::get();
        return view('admin.kamFeshar.addmarkaz', [ 'Provinces' => $Provinces ]);
    }

    public function addmarkaz(Request $request)
    {
        Access::check('Hidro_addmarkaz');

        $markaz = new KamFesharModel($request->all());
        $markaz->save();

        $Provinces = ProvinceModel::get();
        $message = "ثبت شد.";
        return view('admin.kamFeshar.addmarkaz', [ 'Provinces' => $Provinces , 'message' => $message ]);

    }

    public function checkMarkaz($nid, $mobile, $guildNumber)
    {
        $markaz = KamFesharModel::where('NationalID', $nid)->first();
        if(!$markaz)
            return "مرکز کم فشاری با این کدملی وجود ندارد.";
        if($markaz->Cellphone != $mobile)
            return "شماره موبایل با شماره ثبت شده در سامانه مطابقت ندارد.";
        if($markaz->GuildNumber != $guildNumber)
            return "شناصه صنفی وارد شده صحیح نمی باشد";
        return $markaz;
    }

    public function createApi()
    {
        $kamfeshars = KamFesharModel::whereNotNull( 'CodeEtehadie' )->where( 'GuildNumber', '!=', '' )->orderBy( 'CodeEtehadie' )->get();

        return $kamfeshars;
    }
}
