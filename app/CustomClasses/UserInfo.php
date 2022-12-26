<?php 

namespace App\CustomClasses;

class UserInfo
{
    public static function Level($id)
    {
        switch($id):
            case 1:
                $level = "ادمین";
                break;
            case 2:
                $level = "مدیر";
                break;
            case 3:
                $level = "مالی";
                break;
            case 4:
                $level = "بازرسی";
                break;
            case 5:
                $level = "آموزش";
                break;
            case 6:
                $level = "روابط عمومی";
                break;
            case 7:
                $level = "مدیر استان";
                break;
        endswitch;
        
        return $level;
    }
}