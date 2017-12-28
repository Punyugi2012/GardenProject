<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttendanceRequest extends FormRequest
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
            'date'=>'required',
            'employee'=>'required',
            'start_time'=>'required',
            'finish_time'=>'required',
        ];
    }
    public function messages() {
        return [
            'date.required'=>'กรุณาเลือกวัน',
            'employee.required'=>'กรุณาเลือกชื่อนามสกุลพนักงาน',
            'start_time.required'=>'กรุณากรอกเวลาเข้าทำงาน',
            'finish_time.required'=>'กรุณากรอกเวลาออกทำงาน',
        ];
    }
}
