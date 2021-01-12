<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CenterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return in_array($this->user()->role,['admin','manager']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>'required',
            'district'=>'required',
            'province'=>'required',
            'country'=>'required'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'اسم مرکز ضروری میباشد',
            'district.required'=>'ولسوالی ضروری میباشد',
            'province.required'=>'ولایت ضروری میباشد',
            'country.required'=>'کشور ضروری میباشد'
        ];
    }
}
