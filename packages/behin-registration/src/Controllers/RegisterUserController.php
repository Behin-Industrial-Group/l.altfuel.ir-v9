<?php

namespace Registration\Controllers;

use App\CustomClasses\zarinPal;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Registration\Models\RegisterUser;

class RegisterUserController extends Controller
{
    public function showForm()
    {
        return view('RegistrationViews::index');
    }

    public function submitForm(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'national_id' => 'required|numeric|digits:10',
            'mobile' => 'required|numeric|digits:11',
            'price' => 'required|string',
        ]);

        $registerUser = RegisterUser::create([
            'name' => $request->input('name'),
            'national_id' => $request->input('national_id'),
            'mobile' => $request->input('mobile'),
            'price' => $request->input('price'),
        ]);

        $callbackUrl = route('registration.verify');
        $authorityCode = zarinPal::getAuthority($registerUser->price, $registerUser->name, $registerUser->mobile, $callbackUrl);
        $registerUser->update([
            'authority' => $authorityCode,
            'status' => 'pending'
        ]);
        
        return redirect(config('zarinpal.pay_url') . $authorityCode);
    }

    public function verify(Request $request){

        $registerUser = RegisterUser::where('authority', $request->Authority)->first();
        $result = zarinPal::verify($request, $registerUser->price);

        if($result === 0 or $result === 1){
            $registerUser->update([
                'status' => 'failed'
            ]);
        }else{
            $registerUser->update([
                'ref_id' => $result,
                'status' => 'success'
            ]);
        }
        return view('RegistrationViews::verify', ['refId' => $result]);

    }
}

