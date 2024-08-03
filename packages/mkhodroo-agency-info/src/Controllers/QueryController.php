<?php

namespace Mkhodroo\AgencyInfo\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Mkhodroo\AgencyInfo\Models\AgencyInfo;
use Mkhodroo\Cities\Controllers\CityController;
use Mkhodroo\Cities\Controllers\ProvinceController;
use Mkhodroo\Cities\Models\City;
use Mkhodroo\Cities\Models\NewProvince;

class QueryController extends Controller
{
    public static function agencyEditor()
    {
        // self::editProvinceToCity();
        // self::createProvince();
        // self::convertProvinceToOldProvince();
        // self::convertNewProvinceToProvince();
        // 

        // $cities = City::all()->groupBy('province');
        // foreach($cities as $province => $city){
        //     NewProvince::create([
        //         'name' => $province
        //     ]);
        // }
        // $cities = City::all();
        // $provinces = NewProvince::all();
        // $agencies = AgencyInfo::where('key', 'province')->get();
        // foreach ($agencies as $agency) {
        //     $province_name = $cities->where('id', $agency->value)->first()->province;
        //     // echo $provinces->where('name', $province_name)->first()->id . '<br>';
        //     AgencyInfo::create([
        //         'key' => 'province',
        //         'value' => $provinces->where('name', $province_name)->first()->id,
        //         'parent_id' => $agency->parent_id
        //     ]);
        //     $agency->update(['key' => 'city']);
        // }
        // return true;
    }

    public static function editProvinceToCity(){
        $provinces = AgencyInfo::where('key', 'province')->get();
        $cities = AgencyInfo::where('key', 'city')->get();
        if(count($cities)){
            return 'رکورد سیتی درحال حاضر وجود دارد';
        }
        foreach($provinces as $province){
            // create city record from province
            AgencyInfo::create([
                'key' => 'city',
                'value' => $province->value,
                'parent_id' => $province->parent_id
            ]);
            // return $province;
        }
    }

    public static function createProvince(){
        $provinces = AgencyInfo::where('key', 'province')->get();
        foreach($provinces as $province){
            $p_name = CityController::getById($province->value)?->province;
            $pr = ProvinceController::create($p_name);
            if(!AgencyInfo::where('key', 'new_province')->where('parent_id', $province->parent_id)->first()){
                AgencyInfo::create([
                    'key' => 'new_province',
                    'value' => $pr->id,
                    'parent_id' => $province->parent_id
                ]);
                // echo $pr->id. "<br>";

            }
            
        }
    }

    public static function convertProvinceToOldProvince(){
        $provinces = AgencyInfo::where('key', 'province')->get();
        foreach($provinces as $province){
            $province->key = 'old_province';
            $province->save();
        }
    }

    public static function convertNewProvinceToProvince(){
        $provinces = AgencyInfo::where('key', 'new_province')->get();
        foreach($provinces as $province){
            $province->key = 'province';
            $province->save();
        }
    }
}
