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
            'employee.required'=>'กรุณาเลือกชื่อนามสกุลพนักงาน',
            'date.required'=>'กรุณากรอกวันที่',
            'time.required'=>'กรุณากรอกเวลา',
            'round.required'=>'กรุณากรอกรอบ',
            'amount_money.required'=>'กรุณากรอกจำนวนเงิน',
            'cost.required'=>'กรุณากรอกค่าเสียหาย',
        ];
    }
}
