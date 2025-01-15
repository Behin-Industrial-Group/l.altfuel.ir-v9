<?php

namespace IsoAgent\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IsoAgentController extends Controller
{

    public function index()
    {
        return view('IsoAgentViews::index');
    }

}

