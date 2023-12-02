<?php 

namespace Mkhodroo\AgencyInfo\Controllers;


use App\CustomClasses\zarinPal;
use App\Enums\EnumsEntity;
use App\Http\Controllers\Controller;
use App\Models\HidroModel;
use App\Models\KamFesharModel;
use App\Models\MarakezModel;
use App\Models\MessageModel;
use App\Models\User;
use Exception;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Mkhodroo\AgencyInfo\Models\AgencyInfo;

class DebtController extends Controller
{
    private $markazController;
    private $kamfesharController;
    private $marakezModel;
    private $kamfesharModel;
    private $hidroController;
    private $hidroModel;
    private $msg;
    private $user;

    public function __construct() {
        
    }
    public function bedehiHomePage(Request $request){
        return view('AgencyView::debt.index');
    }

    public function checkMarkaz($request)
    {
        $agency = AgencyInfo::where('value', $request->code)->first();
        if(!$agency){
            return response(trans("No Agency Found"), 300);
        }
        $parent_id = $agency->parent_id;
        if(!AgencyInfo::where('parent_id', $parent_id)->where('key', 'national_id')->where('value', $request->nid)->count()){
            return response(trans("No Agency Found With This National ID"), 300);
        } 

        if(!AgencyInfo::where('parent_id', $parent_id)->where('key', 'mobile')->where('value', $request->mobile)->count()){
            return response(trans("No Agency Found With This Mobile Number"), 300);
        } 
        $debts = [];
        foreach(config("agency_info.customer_type.$request->type.debts") as $row){
            $debts[] = [
                'title' => AgencyInfo::where('parent_id', $parent_id)->where('key', $row[3])->first()->value,
                'price' => AgencyInfo::where('parent_id', $parent_id)->where('key', $row[0])->first()->value,
            ];
        }
        $sum = 0;
        foreach($debts as $debt){
            $sum += (int) $debt['price'];
        }
        if($sum === 0){
            return response(trans("You Have No Debt"), 300);
        }
        return [
            'debts' => $debts,
            'sum' => $sum
        ];
    }


    public function confirmBedehi(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'nid' => ['required', 'digits:10'],
            'mobile' => ['required', 'digits:11'],
            'code' => ['required']
        ]);
        
        $checkMarkaz = $this->checkMarkaz($request);
        if(!array($checkMarkaz))
            return $checkMarkaz;
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

    public function confirmForm(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'nid' => ['required', 'digits:10'],
            'mobile' => ['required', 'digits:11'],
            'code' => ['required']
        ]);
        
        $debts = $this->checkMarkaz($request);
        if(!array($debts))
            return $debts;
        return view('AgencyView::debt.confirm')->with(['debts' => $debts['debts'], 'sum' => $debts['sum'] ]);
        
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
            if($type === EnumsEntity::$AgencyType['agency']['value']){
                $this->marakezModel->where('CodeEtehadie', $code)->update(['debt_RefID' => $result]);
                $type_fa = EnumsEntity::$AgencyType['agency']['fa_name'];
            }

            if($type === EnumsEntity::$AgencyType['kamfeshar']['value']){
                $this->kamfesharModel->where('GuildNumber', $code)->update(['debt_RefID' => $result]);
                $type_fa = EnumsEntity::$AgencyType['kamfeshar']['fa_name'];
            }

            if($type === EnumsEntity::$AgencyType['hidro']['value']){
                $this->hidroModel->where('CodeEtehadie', $code)->update(['debt_RefID' => $result]);
                $type_fa = EnumsEntity::$AgencyType['hidro']['fa_name'];
            }

            //ارسال پیام به مالی '
            try{
                $message = "مرکز $type_fa با کدمرکز/شناسه صنفی: $code ";
                $message .= "تسویه مالی را با کد رهگیری: $result  انجام داد.";
                $this->msg->send($this->user->where('level', 3)->first()->id, $message, $code);
            }catch(Exception $e){
                Log::info("خطا در ارسال پیام به مالی پس از انجام تراکنش");
                Log::error($e->getMessage());
            }
            


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