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

    public static function GetCode($province)
    {
        $province = str_replace("گ", "گ", $province);
        $province = str_replace("ك", "ک", $province);
        $province = str_replace("ي", "ی", $province);
        return ProvinceModel::where('Name', $province)->first()?->code;
    }
}
