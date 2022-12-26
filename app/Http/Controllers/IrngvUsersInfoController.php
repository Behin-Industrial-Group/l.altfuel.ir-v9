<?php

namespace App\Http\Controllers;

use App\Http\Validations\IrngvUsersInfoValidation;
use App\Models\IrngvUsersInfo;
use Illuminate\Http\Request;

class IrngvUsersInfoController extends Controller
{
    
    public function store(Request $r)
    {
        $row = IrngvUsersInfo::create($r->except(['api_token']));
        $row->link = $this->create_random_unique_link();
        $row->save();
        return $row;
    }

    public function create_random_unique_link()
    {
        $r = RandomStringController::Generate(10);
        if(IrngvUsersInfo::where('link', $r)->first()){
            $this->create_random_unique_link();
        }
        return $r;
    }
}
