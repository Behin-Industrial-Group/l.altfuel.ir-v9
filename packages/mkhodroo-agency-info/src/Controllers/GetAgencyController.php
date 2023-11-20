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
}
