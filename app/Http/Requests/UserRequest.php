<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'password'=>'required',
            'role'=>'required',
            'center_id'=>'required',
            'email'=>'required|unique:users,email,'.$this->input('id').',id'
        ];
    }
}
