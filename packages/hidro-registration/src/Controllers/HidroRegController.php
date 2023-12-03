<?php

namespace Hidro\Registration\Controllers;

use App\CustomClasses\SimpleXLSX;
use App\CustomClasses\zarinPal;
use App\Http\Controllers\Controller;
use App\Models\HidroModel;
use Illuminate\Http\Request;
use Mkhodroo\AgencyInfo\Controllers\AgencyDebtPaymentController;
use Mkhodroo\AgencyInfo\Controllers\CreateAgencyController;
use Mkhodroo\AgencyInfo\Controllers\GetAgencyController;
use Mkhodroo\AgencyInfo\Models\AgencyInfo;
use SoapClient;

class HidroRegController extends Controller
{
    public static function findForm()
    {
        return view('HidroRegViews::find');
    }

    public static function uploadExcel(Request $r)
    {
        $excel = SimpleXLSX::parse(public_path('hidro.xlsx'));
        $rows = $excel->rows();
        echo "<pre>";
        foreach ($rows as $row) {
            if ($row[1] != 'نام مرکز در سیمفا') {
                // print_r([
                //     'simfaCode' => $row[0],
                //     'Name' => $row[1],
                //     'Address' => $row[2],
                //     'PostalCode' => $row[3],
                //     'legalNationalId' => $row[4],
                //     'Tel' => $row[5],
                //     'debt' => '50000000',
                //     'Details' => "اضافه شده از اکسل سیمفا"
                // ]);
                HidroModel::create([
                    'simfaCode' => $row[0],
                    'Name' => $row[1],
                    'Address' => $row[2],
                    'PostalCode' => (string) $row[3],
                    'legalNationalId' => (string) $row[4],
                    'Tel' => (string)$row[5],
                    'debt' => '50000000',
                    'Details' => "اضافه شده از اکسل سیمفا"
                ]);
            }
        }
    }

    public static function get($simfaCode, $legalNationalId)
    {
        return HidroModel::where('simfaCode', $simfaCode)->where('legalNationalId', $legalNationalId)->first();
    }

    public static function getByAuthority($authority)
    {
        return HidroModel::where('Authority', $authority)->first();
    }

    public static function find($simfaCode, $legalNationalId)
    {
        $parent_id = AgencyInfo::where('key', 'simfa_code')->where('value', $simfaCode)->first()?->parent_id;
        if(!$parent_id){
            return response("Agency Does Not Found", 404);
        }
        $parent_id = AgencyInfo::where('key', 'legal_national_id')->where('value', $legalNationalId)->where('parent_id', $parent_id)->first()?->parent_id;
        if(!$parent_id){
            return response("Agency Does Not Found", 404);
        }
        $ref_id = AgencyInfo::where('key', 'debt1_ref_id')->where('parent_id', $parent_id)->first()?->value;
        if($ref_id){
            return response(trans("You Compelete Your Info Before. Please Be Patient. We Call You Soon."), 300);
        }

        return $parent_id;
        return HidroModel::where('simfaCode', $simfaCode)->where('legalNationalId', $legalNationalId)
            ->select('simfaCode', 'Name', 'Address', 'PostalCode', 'legalNationalId', 'Tel', 'debt')->first();
    }

    public static function compeleteInfoForm(Request $r)
    {
        // $agency = self::get($r->simfaCode, $r->legalNationalId);
        // if (!$agency) {
        //     return response(trans("Agency Does Not Found"), 300);
        // }
        // if($agency->debt_RefID){
        //     return response(trans("You Compelete Your Info Before. Please Be Patient. We Call You Soon."),300);
        // }
        $parent_id = self::find($r->simfaCode, $r->legalNationalId);
        if(!(is_integer($parent_id) or is_string($parent_id))){
            return $parent_id;
        }
        return view('HidroRegViews::compelete-info')->with([
            'agency_fields' => GetAgencyController::getByParentId($parent_id)
        ]);
    }

    public static function pay(Request $r)
    {
        $r->validate([
            'Name' => ['required'],
            'NationalID' => ['required', 'digits:10'],
            'Cellphone' => ['required', 'digits:11'],
            'Province' => ['required', 'string'],
            'City' => ['required', 'string'],
            'standardCertificateNumber' => ['required', 'string'],
            'standardCertificateExpDate' => ['required', 'string'],

        ]);
        CreateAgencyController::createByParentId('firstname', $r->Name, $r->parent_id);
        CreateAgencyController::createByParentId('national_id', $r->NationalID, $r->parent_id);
        CreateAgencyController::createByParentId('mobile', $r->Cellphone, $r->parent_id);
        CreateAgencyController::createByParentId('province', $r->Province, $r->parent_id);
        CreateAgencyController::createByParentId('standard_certificate_number', $r->standardCertificateNumber, $r->parent_id);
        CreateAgencyController::createByParentId('standard_certificate_exp_date', $r->standardCertificateExpDate, $r->parent_id);
        $agency = GetAgencyController::getByParentId($r->parent_id);
        $debt_id = $agency->where('key', 'debt1')->first()->id;
        $amount = $agency->where('key', 'debt1')->first()->value;
        $description =  'کمک مردمی اتصال به سامانه برای مرکز هیدرو به کدملی: ' . $r->NationalID;
        $mobile = $agency->where('key', 'mobile')->first()->value;
        $callbackUrl = route('hidroReg.callback');
        $Authority = zarinPal::getAuthority($amount/10, $description, $mobile, $callbackUrl);
        if($Authority){
            AgencyDebtPaymentController::create($debt_id, $amount, $Authority, 'pending');
            return config('zarinpal.pay_url') . $Authority;
        }
        return response(trans("Authority Does Not Received."),300);
    }

    public static function callback(Request $r){
        $agency = self::getByAuthority($r->Authority);
        // $agency->Authority = '';
        // $agency->save();

        if ($r->Status == 'OK') {
            // URL also can be ir.zarinpal.com or de.zarinpal.com
            $client = new SoapClient(config('zarinpal.payment_verification_url'), ['encoding' => 'UTF-8']);
            $result = $client->PaymentVerification([
                'MerchantID'     => config('zarinpal.merchantId'),
                'Authority'      => $r->Authority,
                'Amount'         => $agency->debt/10,
            ]);
            echo "<pre>";
            print_r($result);
            $agency->debt_RefID = $result->RefID;
            $agency->save();
            return view('HidroRegViews::callback')->with([
                'status' => $result->Status,
                'refId' => $result->RefID,
            ]);
        }else{
            return view('HidroRegViews::callback')->with([
                'status' => $r->Status,
                'authority' => $r->Authority,
            ]);
        }
    }
}
