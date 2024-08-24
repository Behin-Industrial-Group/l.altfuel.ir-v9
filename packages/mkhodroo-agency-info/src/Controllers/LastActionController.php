<?php

namespace Mkhodroo\AgencyInfo\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mkhodroo\AgencyInfo\Models\AgencyInfo;
use Mkhodroo\AgencyInfo\Requests\AgencyInfoRequest;

class LastActionController extends Controller
{
    public static function createNewAction(Request $r)
    {
        $timestamp = Carbon::now()->timestamp;
        $parent_id = $r->id;
        $last_action = Auth::user()->name . ": " . $r->last_action;
        $last_action_file = $r->file('last_action_file');
        $description = null;
        if($last_action_file){
            $uploadResult = FileController::store($last_action_file);
            if($uploadResult['status'] !== 200){
                return response($uploadResult['message'], $uploadResult['status']);
            }
            else{
                $description = $uploadResult['dir'];
            }
        }
        return AgencyInfo::create([
            'key' => 'last_action@' . $timestamp,
            'value' => $last_action,
            'description' => $description,
            'parent_id' => $parent_id
        ]);

        $agency_fields =  AgencyInfo::where('parent_id', $r->id)->get();
        $data = $r->except('id');
        foreach ($data as $key => $value) {
            //files
            if(gettype($r->$key) === 'object'){
                $value = FileController::store($r->file($key), self::docDir($r->id, 'ins'));
                if($value['status'] !== 200){
                    return response($value['message'], $value['status']);
                }
                else{
                    $value = $value['dir'];
                }
            }
            $row = $agency_fields->where('key', $key)->first();
            if ($row) {
                $row->update([
                    'value' => str_replace(',', '', $value)
                ]);
            } else {
                $row = new AgencyInfo();
                $row->key = $key;
                $row->value = str_replace(',', '', $value);
                $row->parent_id = $r->id;
                $row->save();
            }
        }
        return $agency_fields->first();
        // return view('AgencyView::edit')->with([ 'agency_fields' => $agency_fields ]);
    }
}
