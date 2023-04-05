<?php

namespace App\CustomClasses;

use App\CustomClasses\Date;
use App\Http\Controllers\Controller;
use App\Models\IrngvUsersInfo;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Http\Request;

class IrngvUserInfoFilterBy extends Controller
{
    public static function get_all()
    {
        return IrngvUsersInfo::get()->each(function($c){
            $c->link = config('irngv')['irngv-poll-link'] . "$c->link";
        });
    }

    public static function created_at($created_from, $created_to)
    {
        // args created_from and created_to must be in jalali date format 
        $date = Date::toArray($created_from);
        $created_from = Verta::jalaliToGregorian($date[0], $date[1], $date[2]);
        $created_from = Date::gregorianToCarbon($created_from);
        $date = Date::toArray($created_to);
        $created_to = Verta::jalaliToGregorian($date[0], $date[1], $date[2]);
        $created_to = Date::gregorianToCarbon($created_to);

        return IrngvUsersInfo::whereBetween('created_at', [$created_from, $created_to])->get() ;
    }
}
