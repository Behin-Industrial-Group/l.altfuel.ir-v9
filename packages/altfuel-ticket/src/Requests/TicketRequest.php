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
        if(!$this->input('text') and !$this->file('payload')){
            throw ValidationException::withMessages([
                'title' => "متن یا صدا را تکمیل کنید",
            ]);
        }
        if($this->file('file') &&  $this->file('file')->getSize() >= config('ATConfig.max-attach-file-size') * 1024 ){
            throw ValidationException::withMessages([
                'title' => "حجم فایل بیش از مقدار مجاز است. مقدار مجاز: ". config('ATConfig.max-attach-file-size') . "KB",
            ]);
        }
        if($this->file('file') && !in_array($this->file('file')->getClientMimeType(), config('ATConfig.attachment-file-types'))){
            throw ValidationException::withMessages([
                'title' => "فایل پشتیبانی نمیشود. فایل های مجاز: ". implode(' یا ', config('ATConfig.attachment-file-types-translate')),
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
