<?php

namespace Mkhodroo\AgencyInfo\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AgencyInfoRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'national_id' => 'digits:10',
            'guild_number' => 'digits: 10',
            'mobile' => 'digits:11'
        ];
    }
}
