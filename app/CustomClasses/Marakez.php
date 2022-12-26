<?php 

namespace App\CustomClasses;
use App\Models\MarakezModel;
use App\Models\HidroModel;

class Marakez
{
    private static function isMarakaz($nationalId)
    {
        $markaz = MarakezModel::where( 'NationalID', $nationalId )->first();
        if( !is_null($markaz) ){
            return true;
        }
        return false;
    }
    
    private static function isHidro($nationalId)
    {
        $markaz = HidroModel::where( 'NationalID', $nationalId )->first();
        if( !is_null($markaz) ){
            return true;
        }
        return false;
    }
    
    public static function isAgancy($nationalId)
    {
        $markaz = static::isMarakaz($nationalId);
        $hidro = static::isHidro($nationalId);
        
        if($markaz){
            return true;
        }elseif($hidro){
            return true;
        }else{
            return false;
        }
    }
}