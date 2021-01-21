<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user();
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
            'post_code'=>'required',
            'salary'=>'required',
            'type'=>'required',
            'ddg'=>'required',
            'center_id'=>'required',
            'project'=>'required',
            'location'=>'required',
            'grade'=>'required',
            'step'=>'required',
           
        ];
    }

    public function messages(){
        return [
            'name.required'=>'نام بست ضروری میباشد',
            'post_code.required'=>'کود بست ضروری میباشد',
            'salary.required'=>'مقدار ضروری میباشد',
            'type.required '=>'نوعیت بست ضروری میباشد',
            'ddg.required'=>'معاونیت ضروری میباشد',
            'center_id.required'=>'ریاست ویا مرکز ضروری میباشد',
            'project.required'=>'پروژه ضروری میباشد',
            'location.email'=>'موقیعت بست ضروری میباشد',
            'grade.required'=>'گرید بست ضروری میباشد',
            'step.required'=>'قدم بست ضروری میباشد',
        ];
    }
}
