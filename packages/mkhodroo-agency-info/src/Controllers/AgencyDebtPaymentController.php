<?php

namespace Mkhodroo\AgencyInfo\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mkhodroo\AgencyInfo\Models\AgencyDebtPayment;
use Mkhodroo\AgencyInfo\Models\AgencyInfo;
use Mkhodroo\AgencyInfo\Requests\AgencyDocRequest;

class AgencyDebtPaymentController extends Controller
{
    

    public static function getPendingByAuthority($authority) {
        return AgencyDebtPayment::where('authority', $authority)->where('status', 'pending')->get();
    }

    public static function create($row_id, $price, $authority, $status) {
        $row = AgencyDebtPayment::where('agency_info_row_id', $row_id)->first();
        if(!$row){
            AgencyDebtPayment::create([
                'agency_info_row_id' => $row_id,
                'price' => $price,
                'authority' => $authority,
                'status' => $status
            ]);
            return;
        }
        if($row->status == 'pending'){
            $row->authority = $authority;
            $row->save();
            return;
        }
        if($row->status == 'error'){
            AgencyDebtPayment::create([
                'agency_info_row_id' => $row_id,
                'price' => $price,
                'authority' => $authority,
                'status' => $status
            ]);
            return;
        }
        if($row->status == 'done'){
            return response(trans("This Debt Pay Before"), 300);
        }
        

    }
}
