<?php

namespace Mkhodroo\AgencyInfo\Controllers;

use App\Http\Controllers\Controller;
use Mkhodroo\AgencyInfo\Models\AgencyInfo;
use Mkhodroo\Cities\Models\City;
use Mkhodroo\Cities\Models\Province;

class QueryController extends Controller
{
    public static function agencyEditor(){
        $cities = City::all();
        $provinces = Province::all();
        $agencies = AgencyInfo::where('key', 'province')->get();
        // return $agencies;
        foreach($agencies as $agency){
            // $agency->forceDelete();
            // return $agency->value;
            $province_name = $cities->where('id', $agency->value)->first()->province;
            $province = $provinces->where('Name', $province_name)->first();
            if(!$province){
                Province::create([
                    'Name' => $province_name
                ]);
            }
            // AgencyInfo::create([
            //     'key' => 'province',
            //     'value' => $provinces->where('name', $cities->where('id', $agency->value)->pluck('province'))->pluck('id'),
            //     'parent_id' => $agency->parent_id
            // ]);
            // $agency->update(['key' => 'province']);
        }
        return true;
    }
}
