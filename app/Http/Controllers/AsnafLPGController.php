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
            'mobile' => 'string| max_digits:11',
            'nid' => 'string| max_digits:10',
            'monthly_use' => 'numeric'
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
