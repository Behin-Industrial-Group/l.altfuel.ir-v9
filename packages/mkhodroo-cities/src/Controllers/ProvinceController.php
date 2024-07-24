<?php

namespace Mkhodroo\Cities\Controllers;

use App\Http\Controllers\Controller;
use Mkhodroo\Cities\Models\NewProvince;
use Mkhodroo\Cities\Models\Province;

class ProvinceController extends Controller
{
    public static function all(){
        return NewProvince::get();
    }
}
