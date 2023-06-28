<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if(!$this->input('name')){
            throw ValidationException::withMessages([
                'name' => "نام را تکمیل کنید",
            ]);
        }
        if(!$this->input('mobile')){
            throw ValidationException::withMessages([
                'mobile' => "موبایل را وارد کنید",
            ]);
        }
        if(!$this->input('password')){
            throw ValidationException::withMessages([
                'password' => "رمز عبور را وارد کنید",
            ]);
        }
        if(strlen($this->input('mobile')) != 11){
            throw ValidationException::withMessages([
                'mobile' => "شماره موبایل باید 11 رقم باشد"
            ]);
        }
        if(strlen($this->input('password')) < 8){
            throw ValidationException::withMessages([
                'password' => "رمز عبور باید بیشتر از 8 کارکتر باشد"
            ]);
        }
        for($i=0; $i < strlen($this->input('mobile')); $i++){
            if(!is_int( $this->input('mobile')[$i])){
                throw ValidationException::withMessages([
                    'mobile' => "لطفا موبایل را با اعداد انگلیسی وارد کنید"
                ]);
            }
        }
        return [];
        
    }

    public function messages(){
        
    }
}
