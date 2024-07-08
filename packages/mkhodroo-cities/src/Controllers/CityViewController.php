<?php

namespace Mkhodroo\Cities\Controllers;

use App\Http\Controllers\Controller;
use Mkhodroo\Cities\Models\City;

class CityViewController extends Controller
{
    public function index()
    {
        $cities = City::all();
        return view('CitiesViews::index', compact('cities'));
    }



}
