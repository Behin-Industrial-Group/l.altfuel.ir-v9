<?php 

namespace Mkhodroo\HelpSupportRobot\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mkhodroo\HelpSupportRobot\Models\HelpSupport;

class GetController extends Controller
{
    public static function getForm(){
        return view('HelpSupportView::get');
    }
    public static function all(){
        return HelpSupport::get();
    }
    public static function getByParentId(Request $r){
        if($r->parent_id){
            $res  = HelpSupport::where('parent_id', $r->parent_id)->where('parent_id', '!=', DB::raw('id'))->get();
            if(count($res)){
                return $res;
            }
            return HelpSupport::where('id', $r->parent_id)->first();
        }
        return HelpSupport::where('parent_id', DB::raw('id'))->get();
    }
}