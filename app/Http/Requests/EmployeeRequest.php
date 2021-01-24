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
            'name' => 'required',
            'father_name' => 'required',
            'grand_father_name'=>'required',
            'dob' => 'required|date_format:"Y-m-d"',
            'gender' => 'required',
            'marital_status' => 'required',
            'contact_number' => 'required',
            'email' => 'email',
            'center_id' => 'required|exists:centers,id',
            'id_type' => 'required',
            'current_address.line_1' => 'required',
            'current_address.district' => 'required',
            'current_address.province' => 'required',
            'permanent_address.line_1' => 'required',
            'permanent_address.district' => 'required',
            'permanent_address.province' => 'required',
            'id_details.volume' => 'required_if:id_type,"P"',
            'id_details.year' => 'required_if:id_type,"P"',
            'id_details.page' => 'required_if:id_type,"P"',
            'id_details.registration' => 'required_if:id_type,"P"',
            'id_details.sokok' => 'required_if:id_type,"P"',
            'id_details.nid_no' => 'required_if:id_type,"E"',
            'post_id' => 'required'

        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'نام ضروری میباشد',
            'father_name.required' => 'نام پدر ضروری میباشد',
            'grand_father_name.required' => 'نام پدر کلان ضروری میباشد',
            'dob.required|date_format ' => 'سال تولد ضروری بوده و فارمت تاریخ نیز باید درست باشد',
            'gender.required' => 'جنسیت ضروری میباشد',
            'marital_status.required' => 'حالت مدنی ضروری میباشد',
            'contact_number.required' => 'شماره تماس ضروری میباشد',
            'email.email' => 'ایمیل ضروری میباشد',
            'center_id.required|exists' => ' وارد سازی مرکز ضروری میباشد طوریکه موجود باشد',
            'id_type.required' => 'نوعیت ضروری میباشد',
            'current_address.line_1.required' => 'کوچه سکونت فعلی ضروری میباشد',
            'current_address.district.required' => 'ناحیه سکونت فعلی ضروری میباشد',
            'current_address.province.required' => 'ولایت سکونت فعلی ضروری میباشد',
            'permanent_address.line_1.required' => 'کوچه سکونت اصلی ضروری میباشد',
            'permanent_address.district.required' => 'ناحیه سکونت اصلی ضروری میباشد',
            'permanent_address.province.required' => 'ولایت سکونت اصلی ضروری میباشد',
            'id_details.volume.required_if' => 'جلد تذکره ضروری میباشد',
            'id_details.year.required_if' => 'تاریخ صدور ضروری میباشد',
            'id_details.page.required_if' => 'صفحه تذکره ضروری میباشد',
            'id_details.registration.required_if' => 'نمبر ثبت تذکره ضروری میباشد',
            'id_details.sokok.required_if' => 'صکوک تذکره ضروری میباشد',
            'id_details.nid_no.required_if' => 'نمبر تذکره ضروری میباشد',
            'post_id.required' => 'بست ضروری میباشد'

        ];
    }
}
