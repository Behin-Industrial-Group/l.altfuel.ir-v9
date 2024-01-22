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
use Mkhodroo\AgencyInfo\Models\AgencyDebtPayment;
use Mkhodroo\AgencyInfo\Models\AgencyInfo;
use PhpParser\Node\Stmt\Static_;

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

    public static function getDebts($customer_type , $parent_id){
        $debts = [];
        foreach(config("agency_info.customer_type.$customer_type.debts") as $row){
            //IF DEBT DOESNT HAS REF ID 
            if(!AgencyInfo::where('parent_id', $parent_id)->where('key', $row[2])->first()?->value &&
                AgencyInfo::where('parent_id', $parent_id)->where('key', $row[0])->where('value', '!=', '')->first()?->value
            ){
                $debts[] = [
                    'id' => AgencyInfo::where('parent_id', $parent_id)->where('key', $row[0])->first()?->id,
                    'title' => AgencyInfo::where('parent_id', $parent_id)->where('key', $row[3])->first()?->value,
                    'price' => AgencyInfo::where('parent_id', $parent_id)->where('key', $row[0])->first()?->value,
                ];
            }
        }
        return $debts;
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
        $debts = self::getDebts($request->type, $parent_id);
        $sum = 0;
        foreach($debts as $debt){
            $sum += (int) $debt['price'];
        }
        if($sum === 0){
            return response(trans("You Have No Debt"), 300);
        }
        return [
            'debts' => $debts,
            'agency_national_id' => AgencyInfo::where('parent_id', $parent_id)->where('key', 'national_id')->first()->value,
            'agency_code' => AgencyInfo::where('parent_id', $parent_id)->where('key', 'agency_code')->first()?->value,
            'mobile' => AgencyInfo::where('parent_id', $parent_id)->where('key', 'mobile')->first()->value,
            'sum' => $sum
        ];
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
        if(!is_array($debts))
            return $debts;
        return view('AgencyView::debt.confirm')->with(['debts' => $debts['debts'], 'sum' => $debts['sum'], 'data' => $debts ]);

    }
    
    public function pay(Request $request)
    {
        $data = unserialize($request->data);
        $description = trans("Debt Payment For Agency With National ID: "). $data['agency_national_id'] ;
        $description .= " ". trans("Agency Code: "). $data['agency_code'];
        $callbackUrl = route('callback');
        $Authority = zarinPal::getAuthority($data['sum']/10, $description, $data['mobile'], $callbackUrl);
        foreach($data['debts'] as $debt){
            AgencyDebtPaymentController::create($debt['id'], $debt['price'], $Authority, 'pending');
        }
        
        return [
            'message' => trans("Redirecting To Payment Page"),
            'url' => config('zarinpal.pay_url') . $Authority
        ];
    }

    public static function callback(Request $request)
    {
        $agency_payments = AgencyDebtPaymentController::getPendingByAuthority($request->Authority);
        $sum = $agency_payments->sum('price');
        $refId = zarinPal::verify($request, $sum/10);
        
        if( $refId == 0 ){
            self::setErrorForPaymentRecordByAuthority($request->Authority);
            return view('AgencyView::debt.callback')->with([
                'error' => trans("Error")
            ]);

        }
        elseif($refId == 1){
            $message = "تراکنش توسط کاربر لغو شد";
            self::setErrorForPaymentRecordByAuthority($request->Authority);
            return view('AgencyView::debt.callback')->with([
                'error' => trans("Cancel By User")
            ]);

        }
        else
        {
            self::setDoneForPaymentRecordByAuthority($request->Authority, $refId);
            $agency_payments->each(function($row) use($refId){
                $parent_id = AgencyInfo::where('id', $row->agency_info_row_id)->first()->parent_id;
                $key = AgencyInfo::where('id', $row->agency_info_row_id)->first()->key;
                $s = $key . "_pay_date";
                AgencyInfo::where('parent_id', $parent_id)->where('key', $s)->update([
                    'value' => date('Y-m-d')
                ]);
                $s = $key . "_ref_id";
                AgencyInfo::where('parent_id', $parent_id)->where('key', $s)->update([
                    'value' => $refId
                ]);
                $row->ref_id = $refId;
                $row->save();
            });
            return view('AgencyView::debt.callback')->with([
                'message' => trans("Transaction Successful"),
                'refId' => $refId
            ]);

        }
    }

    private static function setErrorForPaymentRecordByAuthority($authority){
        AgencyDebtPaymentController::getPendingByAuthority($authority)->each(function($row){
            $row->status = 'error';
            $row->save();
        });
    }

    private static function setDoneForPaymentRecordByAuthority($authority, $refId){
        AgencyDebtPaymentController::getPendingByAuthority($authority)->each(function($row) use($refId){
            $row->status = 'done';
            $row->ref_id = $refId;
            $row->save();
        });
    }


}