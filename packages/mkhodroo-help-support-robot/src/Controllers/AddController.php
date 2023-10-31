<?php 

namespace Mkhodroo\HelpSupportRobot\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mkhodroo\HelpSupportRobot\Models\HelpSupport;

class AddController extends Controller
{
    public static function addForm(){
        return view('HelpSupportView::add')->with([
            'datas' => GetController::all()
        ]);
    }

    public static function add(Request $r){
        if($r->parent_id){
            $row = new HelpSupport();
            $row->key = $r->key;
            $row->value = $r->value;
            $row->parent_id = $r->parent_id;
            $row->save();
        }else{
            $row = new HelpSupport();
            $row->key = $r->key;
            $row->value = $r->value;
            $row->save();
            $row->parent_id = $row->id;
            $row->save();
        }
       
    }
}