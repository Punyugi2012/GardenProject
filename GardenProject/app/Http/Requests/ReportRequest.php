<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportRequest extends FormRequest
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
            'detail'=>'required',
            'date'=>'required',
            'time'=>'required',
            'type'=>'required',
            'employee'=>'required',
            'assignment'=>'required',
        ];
    }
    public function messages()
    {
        return [
            'detail.required'=>'กรุณากรอกรายละเอียด',
            'date.required'=>'กรุณากรอกวันที่',
            'time.required'=>'กรุณากรอกเวลา',
            'type.required'=>'กรุณาเลือกประเภท',
            'employee.required'=>'กรุณาเลือกพนักงาน',
            'assignment.required'=>'กรุณาเลือกการมอบหมายงาน',
        ];
    }
}
