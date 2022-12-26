<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ProvinceModel;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    private $model;

    public function __construct() {
        $this->model = new ProvinceModel();
    }

    public function GetAll()
    {
        return $this->model->get();
    }

    public function GetCode($province)
    {
        return $this->model->where('Name', $province)->first()->code;
    }
}
