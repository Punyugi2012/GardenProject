<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TakeRequest extends FormRequest
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
            'time'=>'required',
            'employee'=>'required',
            'assignment'=>'required'
        ];
    }
    public function messages()
    {
        return [
            'date.required'=>'กรุณากรอกวันที่',
            'time.required'=>'กรุณากรอกเวลา',
            'employee.required'=>'กรุณาเลือกพนักงาน',
            'assignment.required'=>'กรุณาเลือกการมอบหมายงาน'
        ];
    }
}