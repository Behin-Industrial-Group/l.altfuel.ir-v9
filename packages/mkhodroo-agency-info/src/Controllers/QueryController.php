<?php

namespace Mkhodroo\AgencyInfo\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Mkhodroo\AgencyInfo\Models\AgencyInfo;
use Mkhodroo\Cities\Models\City;
use Mkhodroo\Cities\Models\NewProvince;

class QueryController extends Controller
{
    public static function agencyEditor()
    {
        $cities = City::all()->groupBy('province');
        foreach($cities as $province => $city){
            NewProvince::create([
                'name' => $province
            ]);
        }
        $cities = City::all();
        $provinces = NewProvince::all();
        $agencies = AgencyInfo::where('key', 'province')->get();
        foreach ($agencies as $agency) {
            $province_name = $cities->where('id', $agency->value)->first()->province;
            // echo $provinces->where('name', $province_name)->first()->id . '<br>';
            AgencyInfo::create([
                'key' => 'province',
                'value' => $provinces->where('name', $province_name)->first()->id,
                'parent_id' => $agency->parent_id
            ]);
            $agency->update(['key' => 'city']);
        }
        return true;
    }
}
