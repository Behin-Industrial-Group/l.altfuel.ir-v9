<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mkhodroo\Voip\Controllers\VoipController;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.dashboard')->with([
            // 'voip_poll_info' => VoipController::get_voip_poll_info(),
            // 'call_report' => VoipController::getCallReport(auth()->user()->ext_num)
        ]);
    }
}
