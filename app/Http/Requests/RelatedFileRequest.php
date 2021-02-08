<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RelatedFileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true ;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'f_id' => 'required|exists:files,id',
            'emp_id' => 'required|exists:employees,id',
        ];
    }

   
    public function messages()
    {
        return [
            'f_id.required' => 'فایل ضروری میباشد',
            'f_id.exists' => 'فایل موجود نمی باشد',
            'emp_id.required' => 'کارمند ضروری میباشد',
            'emp_id.exists' => 'کارمند موجود نمی باشد',
        ];
    }
}
