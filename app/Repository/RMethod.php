<?php

namespace App\Repository;

use App\Models\MethodsModel;

class RMethod{
    private $model;

    public function __construct() {
        $this->model = new MethodsModel();
    }

    public function add_method($name, $fa_name)
    {
        $this->model->insert([
            'name' => $name,
            'fa_name' => $fa_name
        ]);
    }
}