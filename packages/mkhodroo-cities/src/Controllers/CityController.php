<?php

namespace Mkhodroo\Cities\Controllers;

use App\Http\Controllers\Controller;
use Mkhodroo\Cities\Models\City;

class CityController extends Controller
{
    public static function all(){
        return City::get();
    }

    public static function getById($id){
        return City::find($id);
    }

    public static function getCityByName($province, $city){
        return City::where('province', $province)->where('city', $city)->first();
    }
    
    public static function create($province, $city){
        return City::updateOrCreate([
            'province' => $province,
            'city' => $city
        ], []);
    }
}
