<?php

namespace Mkhodroo\AltfuelTicket\Requests;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class TicketRequest extends FormRequest
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
        // throw ValidationException::withMessages([
        //     'title' => $this->file('file')->getClientMimeType(),
        // ]);
        if(!$this->input('text') and !$this->file('payload')){
            throw ValidationException::withMessages([
                'title' => "متن یا صدا را تکمیل کنید",
            ]);
        }
        if(!in_array($this->file('file')->getClientMimeType(), ['image/png'] )){
            throw ValidationException::withMessages([
                'title' => "فایل پشتیبانی نمیشود",
            ]);
        }
        if(!$this->input('ticket_id')){
            Log::info($this->input('ticket_id'));
            return [
                'catagory' => 'required|integer',
                'title' => 'required|string',
            ];
        }
        return [];
        
    }

    public function messages(){
        return [
            'catagory.required' => "لطفا دسته بندی را انتخاب کنید",
            'title.required' => "لطفا عنوان را وارد کنید",
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate()
    {

    }
}
