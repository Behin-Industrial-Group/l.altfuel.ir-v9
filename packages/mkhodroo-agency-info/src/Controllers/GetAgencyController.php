<?php 

namespace Mkhodroo\AgencyInfo\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Mkhodroo\AgencyInfo\Models\AgencyInfo;

class GetAgencyController extends Controller
{
    public static function getByKey($parent_id, $key)
    {
        return AgencyInfo::where('parent_id', $parent_id)->where('key', "$key")->first();
    }

    public static function getByParentId($parent_id)
    {
        return AgencyInfo::where('parent_id', $parent_id)->get();
    }

    public static function getByKeyValue($key, $value)
    {
        $parent_id = AgencyInfo::where('key', $key)->where('value', $value)->first()?->parent_id;
        if($parent_id){
            return self::getByParentId($parent_id);
        }
        return;
    }
    
}
