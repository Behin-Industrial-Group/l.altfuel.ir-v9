<?php

namespace UserProfile\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{

    public function index(){
        return view('UserProfileViews::index')->with([
            'user' => Auth::user()
        ]);
    }
}
