<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
            'father_name'=>'required',
           // 'grand_father_name'=>'required',
            'dob'=>'required|date_format:"Y-m-d"',
            'gender'=>'required',
            'marital_status'=>'required',
            'contact_number'=>'required',
            'email'=>'email',
            'center_id'=>'required|exists:centers,id',
            'id_type'=>'required',
            'current_address.line_1'=>'required',
            'current_address.district'=>'required',
            'current_address.province'=>'required',
            'permanent_address.line_1'=>'required',
            'permanent_address.district'=>'required',
            'permanent_address.province'=>'required',
            'id_details.volume'=>'required_if:id_type,"P"',
            'id_details.year'=>'required_if:id_type,"P"',
            'id_details.page'=>'required_if:id_type,"P"',
            'id_details.year'=>'required_if:id_type,"P"',
            'id_details.registration'=>'required_if:id_type,"P"',
            'id_details.sokok'=>'required_if:id_type,"P"',
            'id_details.nid_no'=>'required_if:id_type,"E"',
            'section'=>'required',
            'directorate'=>'required',
            'position_code'=>'required',
            'position_type'=>'required',
            'post_title'=>'required',
            'project_name'=>'required'
        ];
    }

    public function messages(){
        return [
            'name.required'=>'نام ضروری است',
            'father_name.required'=>'نام پدر ضروری است',
            'id_details.volume.required_if'=>'جلد تذکره ضروری است'
        ];
    }
}
