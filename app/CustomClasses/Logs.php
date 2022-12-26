<?php 

namespace App\CustomClasses;

use App\Models\LogsModel;
use Auth;
use Verta;

class Logs
{
    public static function create($act, $table_name, $record_id, $column = null, $descripe = null)
    {
        $Date = Verta();
        if(  Auth::user() == null )
            $user_id = 0;
        else
            $user_id = Auth::user()->id;
            
        LogsModel::create([
            'user_id' => $user_id,
            'act' => $act,
            'table_name' => $table_name,
            'record_id' => $record_id,
            'column_name' => $column,
            'descripe' => $descripe,
            'updated_at' => $Date,
            'created_at' => $Date,
            ]);
    }
    
    private function getLastLogs($table,$record_id)
    {
        $Logs = LogsModel::where('table_name', $table)->where('record_id', $record_id);
        return $Logs;
    }
    
    public function getLastLog($table,$record_id)
    {
        //$Logs = $this->getLastLogs;
        
        return $lastLog;
    }
    
    public static function lastLog($table,$record_id)
    {
        $lastLog = LogsModel::join('users', 'logs.user_id', 'users.id')->where('table_name', $table)->where('record_id', $record_id)->latest('logs.id')->first();
        return $lastLog;
        
    }
}