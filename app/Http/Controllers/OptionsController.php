<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Option;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OptionsController extends Controller
{
    private $model; 

    public function __construct() {
        $this->model = new Option();
    }

    public function show_options()
    {
        $max_upload_file_size = $this->model->where('key', 'max_upload_file_size')->first();
        if($max_upload_file_size)
            $max_upload_file_size = $max_upload_file_size->value;
        return view('admin.show-options')->with([ 'max_upload_file_size' => $max_upload_file_size ]);
    }

    public function update_options(Request $r)
    {
        try{
            $m = $this->model->where('key', 'max_upload_file_size')->first();
            if($m)
                $m->value = $r->max_upload_file_size;
            else{
                $m = new Option();
                $m->key = 'max_upload_file_size';
                $m->value = $r->max_upload_file_size;
            }

            $m->save();
            return 200;
        }
        catch(Exception $e){
            Log::error($e->getMessage());
            return 'خطا در ذخیره اطلاعات';
        }
        
    }
}
