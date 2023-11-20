<?php

namespace Mkhodroo\AgencyInfo\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AgencyDocRequest extends FormRequest
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
            'archive_docs' => [ 'mimes:jpg,pdf' ]
        ];
    }
}
