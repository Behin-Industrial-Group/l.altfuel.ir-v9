<?php

namespace App\CustomClasses;

use App\Models\AccessModel;
use App\Models\MethodsModel;
use App\Models\DisableModel;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Psr7\Request;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Date
{
    public static function toArray($date)
    {
        if(str_contains($date, "-")){
            return array_map('intval', explode("-", $date));
        }
        if(str_contains($date, "/")){
            return array_map('intval', explode("/", $date));
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

    public static function jalaliToGregorian($date, $return_array = true)
    {
        if( !is_array($date) ){
            $date = self::toArray($date);
        }
        $date = Verta::jalaliToGregorian($date[0], $date[1], $date[2]);
        if($return_array){
            return $date;
        }
        $date = $date[0] . '-' . $date[1] . '-' . $date[2];
        return $date;
    }
}
