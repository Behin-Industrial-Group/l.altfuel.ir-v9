<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\MarakezModel;

class SearchBoxController extends Controller
{
    public function search(Request $r){
        $results = DB::table($r->table_name)->where("$r->column_name", 'like' , "%$r->value%")->get();
        
        switch($r->table_name)
        {
            case 'comments':
                return $this->showCommentView($results);
                break;
            
            default :
                return $this->DefaultView($results);
                break;
        }
    }
    
    private function showCommentView($results)
    {
        return view('admin.search-box.showCommentView')->with([ 'results' => $results ]);
    }
    
    private function DefaultView($results)
    {
        return view('admin.search-box.DefaultView')->with([ 'results' => $results ]);
    }
    
    public function getTableColumns($q)
    {
        $columns = \Schema::getColumnListing($q);
        $n = count($columns);
        $options = "";
        for($i=0; $i<$n; $i++)
        {
            $options = $options . "<option value='$columns[$i]'>$columns[$i]</option>";
        }
        return $options;
    }
}
