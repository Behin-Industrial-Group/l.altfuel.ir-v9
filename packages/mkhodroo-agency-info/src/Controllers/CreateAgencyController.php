<?php 

namespace Mkhodroo\AgencyInfo\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mkhodroo\AgencyInfo\Models\AgencyInfo;

class CreateAgencyController extends Controller
{
    public static function view(){
        return view('AgencyView::create');
    }

    public static function create(Request $r){
        $row = new AgencyInfo();
        $data = $r->all();
        foreach($data as $key => $value){
            $row->key = $key;
            $row->value = $value;
            $row->save();
            $row->parent_id = $row->id;
            $row->save();
        }
        return $row;
    }
}
