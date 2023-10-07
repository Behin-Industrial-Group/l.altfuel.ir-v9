<?php 

namespace Mkhodroo\MkhodrooProcessMaker\Controllers;

use App\Http\Controllers\Controller;
use Mkhodroo\MkhodrooProcessMaker\Models\PMVariable;

class VariableController extends Controller
{
    public static function getByVarId($varId){
        return PMVariable::where('var_uid', $varId)->first();
    }

    public static function getByProcessId($process_id){
        return PMVariable::where('process_uid', $process_id)->get();
    }

    public static function saveToDb($pro_uid, $var_uid, $var_title, $var_type, $accepted_value, $default_value){
        PMVariable::updateOrCreate(
            [
                'process_uid' => $pro_uid,
                'var_uid' => $var_uid
            ],
            [
                'var_title' => $var_title, 
                'type' => $var_type,
                'accepted_value' => $accepted_value,
                'default_value' => $default_value
            ]
        );
    }
    
}