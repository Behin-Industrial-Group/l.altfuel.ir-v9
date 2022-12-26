<?php 

namespace App\Http\Controllers;

use App\CustomClasses\zarinPal;
use App\Enums\EnumsEntity;
use App\Models\KamFesharModel;
use App\Models\MarakezModel;
use App\Models\MessageModel;
use App\Models\User;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Http\Request;


class FinController extends Controller
{
    private $markazController;
    private $kamfesharController;
    private $marakezModel;
    private $kamfesharModel;
    private $msg;
    private $user;

    public function __construct() {
        $this->markazController = new MarakezController();
        $this->kamfesharController = new KamFesharController();
        $this->marakezModel = new MarakezModel();
        $this->kamfesharModel = new KamFesharModel();
        $this->msg = new MessageController();
        $this->user = new User();
    }
    public function bedehiHomePage(Request $request){
        return view('bedehi.index');
    }

    public function checkMarkaz($request)
    {
        if($request->type === EnumsEntity::$AgencyType['agency']['value']){
            $markaz = $this->markazController->checkMarkaz($request->nid, $request->mobile, $request->code);
        }
        if($request->type === EnumsEntity::$AgencyType['kamfeshar']['value']){
            $markaz = $this->kamfesharController->checkMarkaz($request->nid, $request->mobile, $request->code);
        }

        if(!isset($markaz->id))
            return $markaz;
        if($markaz->debt == 0)
            return "بدهی ندارید";
        return $markaz;
    }


    public function confirmBedehi(Request $request)
    {
        $v = $this->bedehi_form_validation($request);
        if($v)
            return response($v, 300);
        
        $checkMarkaz = $this->checkMarkaz($request);
        if(!isset($checkMarkaz->id))
            return response($checkMarkaz, 300);
        
        return response([
            'msg' => 'به صفحه پرداخت منتقل میشوید...',
            'url' => route('confirm-form', [
                'type' => $request->type,
                'nid' => $request->nid,
                'mobile' => $request->mobile,
                'code' => $request->code,
            ])
        ]);
    }

    public function confirmForm($type, $nid, $mobile, $code)
    {
        if($type === EnumsEntity::$AgencyType['kamfeshar']['value'])
            $markaz = KamFesharModel::where('NationalID', $nid)
                ->where('Cellphone', $mobile)
                ->where('GuildNumber', $code)
                ->first();
        if($type === EnumsEntity::$AgencyType['agency']['value']){
            $markaz = MarakezModel::where('NationalID', $nid)
                ->where('Cellphone', $mobile)
                ->where('CodeEtehadie', $code)
                ->first();
        }
        return view('bedehi.confirm')->with(['markaz' => $markaz, 'type' => $type]);
        
    }

    public function bedehi_form_validation($r)
    {
        if(!$r->type)
            return "نوع مرکز را انتخاب کنید";

    }
    
    public function pay(Request $request)
    {
        $markaz = $this->checkMarkaz($request);


        // if($markaz->debt === 0 || !($markaz)){
        //     return view('bedehi.index')->with(['error' => 'خطایی رخ داده است. مجدد تلاش کنید']);
        // }
        // // return var_dump($request->accept);
        if(!$request->accept){
            return view('bedehi.confirm')->with([
                'markaz' => $markaz, 
                'type' => $request->type, 
                'error' => 'لطفا گزینه صحت اطلاعات را فعال کنید'
            ]);
        }

        $debt = $markaz->debt / 10;
        $payInfo = [
            'amount' => $debt,
            'description' => 'بدهی حق عضویت -' . $request->code,
            'mobile' => $request->mobile,
            'callbackUrl' => url('bedehi/success') . "/$request->type/$request->code/$debt",
            ];
        $result = zarinPal::pay($payInfo);
        if(!$result)
            return var_dump($result);
        return $result;
    }

    public function success(Request $request, $type, $code, $price)
    {
        $result = zarinPal::verify($request, $price);
        
      
        if( $result == 0 ){
            $message = "پرداخت ناموفق";
            return view( 'bimeh.unsuccess' )-> with( [ 'message' => $message ] );
        }
        elseif($result == 1){
            $message = "تراکنش توسط کاربر لغو شد";
            return view( 'bimeh.unsuccess' )-> with( [ 'message' => $message ] );
        }
        else
        {
            //کد رهگیری رو در جدول مراکز ثبت کن 
            if($type === EnumsEntity::$AgencyType['agency']['value'])
                $this->marakezModel->where('CodeEtehadie', $code)->update(['debt_RefID' => $result]);

            if($type === EnumsEntity::$AgencyType['kamfeshar']['value'])
                $this->kamfesharModel->where('GuildNumber', $code)->update(['debt_RefID' => $result]);

            //ارسال پیام به مالی 
            $this->msg->send($this->user->where('level', 3)->first()->id,'مرکز '.$code. 'تسویه مالی را با کدرهگیری '.$result. 'انجام داد.', $code);


            $date = Verta();
            $successfulPayInfo = [
                'codeEtehadie' => $code,
                'RefID' => $result,
                'price' => $price,
                'date' => $date,
                ];
            
            return view( 'bimeh.success' )->with( [ 'successfulPayInfo' => $successfulPayInfo] );
        }
    }


}