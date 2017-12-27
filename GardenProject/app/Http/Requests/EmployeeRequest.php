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
        return true;
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
            'surname'=>'required',
            'phone'=>'required',
            'nationality'=>'required',
            'salary'=>'required',
            'gender'=>'required',
        ];
    }
    public function messages() {
        return [
            'name.required'=>'กรุณากรอกชื่อ',
            'surname.required'=>'กรุณากรอกนามสกุล',
            'phone.required'=>'กรุณากรอกเบอร์โทรศัพท์',
            'nationality.required'=>'กรุณาเลือกสัญชาติ',
            'salary.required'=>'กรุณากรอกจำนวนเงินเดือน',
            'gender.required'=>'กรุณาเลือกเพศ',
        ];
    }
}
