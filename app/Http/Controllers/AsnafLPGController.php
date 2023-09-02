<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AsnafLPG;
use App\Models\Cities;
use Illuminate\Http\Request;

class AsnafLPGController extends Controller
{
    function registerForm() {
        return view('asnaf_lpg')->with([
            'cities' => Cities::get()
        ]);
    }

    function register(Request $r) {
        $r->validate([
            'fname' => 'required',
            'lname' => 'required',
            'mobile' => 'required|digits:11',
            'nid' => 'required|string| max_digits:10',
            'monthly_use' => 'required|numeric',
            'asnaf_catagory' => 'required',
            'father_name' => 'required | string',
            'birth_date' => 'required',
            'postal_code' => 'required | digits:10',
            'address' => 'required',

        ]);
        AsnafLPG::updateOrCreate(
            [
                'fname' => $r->fname,
                'lname' => $r->lname,
                'nid' => $r->nid
            ], 
            $r->all()
        );
    }
}
