<?php

namespace Mkhodroo\AgencyInfo\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mkhodroo\AgencyInfo\Models\AgencyInfo;
use Mkhodroo\Cities\Controllers\CityController;
use Mkhodroo\DateConvertor\Controllers\SDate;

class AgencyListController extends Controller
{
    public static function view()
    {
        // return AgencyInfo::groupBy('key')->pluck('key')->toArray();
        return view('AgencyView::list')->with([
            'cols' => self::getKeys()
        ]);
    }

    public static function getKeys(){
        return AgencyInfo::groupBy('key')->pluck('key');
    }

    public static function list()
    {
        return [
            'data' => []
        ];
    }
    public static function filterList(Request $r)
    {   
        
        $main_field = config('agency_info.main_field_name');
        if($r->field_value === null and $r->$main_field === null){
            $agencies =  AgencyInfo::where('parent_id', DB::raw('id'))->get();
        }else{
            if($r->field_value == null){
                $agencies =  AgencyInfo::where('value', $r->$main_field)->groupBy('parent_id')->get();
            }
            elseif($r->$main_field == null){
                $agencies =  AgencyInfo::where('value', 'like', "%". $r->field_value. "%")->groupBy('parent_id')->get();
            }else{
                $parent_ids =  AgencyInfo::where('value', 'like', "%". $r->field_value. "%")->groupBy('parent_id')->pluck('parent_id');
                $agencies = AgencyInfo::whereIn('id', $parent_ids)->where('value', $r->$main_field)->groupBy('parent_id')->get();
            }
            

        }
        // return $agencies;
        $key_indexes = explode(',', $r->cols);
        $agencies =  $agencies->each(function ($agency) use($key_indexes) {
            $keys = self::getKeys();
            foreach($key_indexes as $key_index){
                $key = $keys[$key_index];
                if($key === 'province'){
                    $agency->$key = CityController::getById(GetAgencyController::getByKey($agency->parent_id, $key)?->value)->province;
                }else{
                    $agency->$key = __(GetAgencyController::getByKey($agency->parent_id, $key)?->value);
                }
            }
            $agency->fin_green = __(GetAgencyController::getByKey($agency->parent_id, 'fin_green')?->value);
            

        });
        return ['data' => $agencies];
    }

    public static function getValidAgencies($type = 'agency'){
        $parent_ids = AgencyInfo::where('key', 'customer_type')->where('value', $type)->pluck('id');
        $parent_ids = AgencyInfo::whereIn('parent_id', $parent_ids)->where('key', 'enable')->where('value', '1')->pluck('parent_id');
        $exp_dates = AgencyInfo::whereIn('parent_id', $parent_ids)->where('key', 'exp_date')->whereNotNull('value')->where('value', '!=', '')->get();
        $parent_ids = [];
        $sDate = new SDate();
        $agencies = [];
        foreach($exp_dates as $exp_date){
            $exp = SDate::jalaliToGregorian($exp_date->value);
            $GregorianExpDate = SDate::gregorianToCarbon($exp);
            $now_carbon = Carbon::now();
            $diff = $now_carbon->diffInDays($GregorianExpDate, false);
            if($diff >= 0){
                $parent_ids[] = $exp_date->parent_id;
                $agencies[] = [
                    'agency_code' => GetAgencyController::getByKey($exp_date->parent_id, 'agency_code')?->value,
                    'name' => GetAgencyController::getByKey($exp_date->parent_id, 'firstname')?->value,
                    'province' => CityController::getById(GetAgencyController::getByKey($exp_date->parent_id, 'province')?->value)->province,
                    'city' => CityController::getById(GetAgencyController::getByKey($exp_date->parent_id, 'province')?->value)->city,
                    'address' => GetAgencyController::getByKey($exp_date->parent_id, 'address')?->value,
                    'phone' => GetAgencyController::getByKey($exp_date->parent_id, 'phone')?->value,
                    'mobile' => GetAgencyController::getByKey($exp_date->parent_id, 'mobile')?->value,
                    'exp_date' => GetAgencyController::getByKey($exp_date->parent_id, 'exp_date')?->value,
                ];
            }
        }
        return json_encode($agencies);

    }

}
