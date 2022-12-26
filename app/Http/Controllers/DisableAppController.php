<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DisableModel;
use App\Repository\RDisable;
use Illuminate\Http\Request;

class DisableAppController extends Controller
{
    protected $RDisable;

    public function __construct()
    {
        $this->RDisable = new RDisable();
    }
    public function Index()
    {
        return view('admin.disable.index');
    }

    public function SetDisable(Request $request)
    {
        $this->RDisable->SetIps($request);
        return 'done';
    }

    public function GetAllIps()
    {
        return json_encode(DisableModel::get());
    }

    public function EnableApp()
    {
        DisableModel::truncate();
    }

    
}
