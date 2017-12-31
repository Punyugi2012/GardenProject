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
            'date'=>'required',
            'time'=>'required',
            'round'=>'required',
            'amount_money'=>'required',
            'cost'=>'required',
        ];
    }
    public function messages() {
        return [
            'employee'=>'กรุณาเลือกชื่อนามสกุลพนักงาน',
            'date'=>'กรุณากรอกวันที่',
            'time'=>'กรุณากรอกเวลา',
            'round'=>'กรุณากรอกรอบ',
            'amount_money'=>'กรุณากรอกจำนวนเงิน',
            'cost'=>'กรุณากรอกค่าเสียหาย',
        ];
    }
}
