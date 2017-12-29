<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalaryRequest extends FormRequest
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
            'date_time'=>'required',
            'round'=>'required',
            'amount_money'=>'required',
            'cost'=>'required',
        ];
    }
    public function messages() {
        return [
            'employee'=>'กรุณาเลือกชื่อนามสกุลพนักงาน',
            'date_time'=>'กรุณากรอกวัน/เดือน/ปี/เวลา',
            'round'=>'กรุณากรอกรอบ',
            'amount_money'=>'กรุณากรอกจำนวนเงิน',
            'cost'=>'กรุณากรอกค่าเสียหาย',
        ];
    }
}
