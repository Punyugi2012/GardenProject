<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeaveRequest extends FormRequest
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
            'employee'=>'required',
            'from_date'=>'required',
            'to_date'=>'required',
            'type'=>'required',
            'cause'=>'required',
        ];
    }
    public function messages() {
        return [
            'employee.required'=>'กรุณาเลือกชื่อนามสกุลพนักงาน',
            'from_date.required'=>'กรุณากรอกจากวันที่',
            'to_date.required'=>'กรุณากรอกถึงวันที่',
            'type.required'=>'กรุณาเลือกประเภท',
            'cause.required'=>'กรุณากรอกสาเหตุ'
        ];
    }
}
