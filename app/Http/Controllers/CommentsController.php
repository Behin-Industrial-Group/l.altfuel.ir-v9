<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Verta;

use App\Models\CommentsModel;
use Exception;

class CommentsController extends Controller
{
    private function redirectTo($r)
    {
        return redirect("$r->callbackUrl");
    }
    
    public function set(Request $r)
    {
        try
        {
            $comment = new CommentsModel($r->all());
            $comment->save();
            return 'done';
        }
        catch(Exception $e)
        {
            return $e->getMessage();
        }
        
    }
    
    public static function get($table_name, $record_id)
    {
        $comments = CommentsModel::where('table_name', $table_name)->where('record_id', $record_id)->get();
        return $comments;
    }
}
