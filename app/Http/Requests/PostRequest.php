<?php

namespace App\Http\Requests;

use \Illuminate\Http\Request;
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
    public function rules(Request $request)
    {
        $result = json_decode(collect($request->server()));
        if ($result->REQUEST_METHOD == strtoupper("put")) {
            return [
                'name' => 'required',
                'post_code' => 'required',
                'salary' => 'required',
                'type' => 'required',
                'ddg' => 'required',
                'center_id' => 'required|exists:centers,id',
                'project' => 'required',
                'location' => 'required',
                'step' => 'integer',

            ];
        } else {
            return [
                'name' => 'required',
                'post_code' => 'required|unique:posts,post_code',
                'salary' => 'required',
                'type' => 'required',
                'ddg' => 'required',
                'center_id' => 'required|exists:centers,id',
                'project' => 'required',
                'location' => 'required',
                // 'grade'=>'required',
                'step' => 'integer',

            ];
        }
    }

    public function messages()
    {
        return [
            'name.required' => 'نام بست ضروری میباشد',
            'post_code.required' => 'کود بست ضروری میباشد',
            'post_code.unique' => 'کود بست باید یونیک باشد ',
            'salary.required' => 'مقدار ضروری میباشد',
            'type.required ' => 'نوعیت بست ضروری میباشد',
            'ddg.required' => 'معاونیت ضروری میباشد',
            'center_id.required' => ' وارد سازی مرکز ضروری میباشد   ',
            'center_id.exists' => 'مرکز وارد شده موجود نمی باشد',
            'project.required' => 'پروژه ضروری میباشد',
            'location.email' => 'موقیعت بست ضروری میباشد',
            // 'grade.required'=>'گرید بست ضروری میباشد',
            'step.integer' => 'قدم بست باید عدد باشد ',
        ];
    }
}
