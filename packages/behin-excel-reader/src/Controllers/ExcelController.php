<?php

namespace ExcelReader\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ExcelController extends Controller
{
    public function input()
    {
        return view('ExcelView::input');
    }

    public function read(Request $request)
    {
        if ($xlsx = ExcelReader::parse($request->file)) {
            foreach($xlsx->rows() as $row){
                foreach($row as $cell){
                    dd($cell);
                }
            }
        } else {
            echo ExcelReader::parseError();
        }
    }
}
