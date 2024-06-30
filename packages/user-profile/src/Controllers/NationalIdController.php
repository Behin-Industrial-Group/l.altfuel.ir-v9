<?php

namespace UserProfile\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use UserProfile\Models\UserProfile;

class NationalIdController extends Controller
{
    public function store(Request $request){
        $validated = $request->validate([
            'national_id' => ['required', 'unique', 'numeric', 'digits:10']
        ]);
        UserProfile::updateOrCreate(
            [
                'user_id' => Auth::id()
            ],
            [
                'national_id' => $request->national_id
            ]
        );
    }
}
