<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeductionRequest extends FormRequest
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
            'total_money'=>'required',
            'employee'=>'required',
            'take'=>'required'
        ];
    }
    public function messages()
    {
        return [
            'date.required'=>'กรุณากรอกวันที่',
            'total_money.required'=>'กรุณากรอกจำนวนเงินทั้งหมด',
            'employee.required'=>'กรุณาเลือกพนักงาน',
            'take.required'=>'กรุณาเลือกการเบิก'
        ];
    }
}
