<?php
namespace App\Repository;

use App\Models\DisableModel;

class RDisable
{
    protected $model;

    public function __construct()
    {
        $this->model = new DisableModel();
    }

    public function SetIps($request)
    {
        $row = count($request->ip);
        for($i=0; $i<$row; $i++){
            $disable = new DisableModel();
            $disable->ip = $request->ip[$i];
            $disable->save();
        }
    }
}