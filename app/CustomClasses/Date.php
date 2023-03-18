<?php

namespace App\CustomClasses;

use App\Models\AccessModel;
use App\Models\MethodsModel;
use App\Models\DisableModel;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;

class Date
{
    public static function toArray($date)
    {
        if(str_contains($date, "-")){
            return explode("-", $date);
        }
        if(str_contains($date, "/")){
            return explode("/", $date);
        }
    }    

    public static function gregorianToCarbon($date)
    {
        if(is_array($date)){
            return Carbon::createFromFormat('Y-m-d', $date[0] . "-" . $date[1] . "-" . $date[2]);
        }
        if(str_contains($date, "-")){
            return Carbon::createFromFormat('Y-m-d', $date);
        }
        if(str_contains($date, "/")){
            return Carbon::createFromFormat('Y/m/d', $date);
        }
    }
}
