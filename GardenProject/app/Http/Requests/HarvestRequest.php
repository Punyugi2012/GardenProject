<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HarvestRequest extends FormRequest
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
            'amount'=>'required',
            'date'=>'required',
            'time'=>'required',
            'assignment'=>'required',
            'product'=>'required',
        ];
    }
    public function messages()
    {
        return [
            'amount.required'=>'กรุณากรอกจำนวน',
            'date.required'=>'กรุณากรอกวันที่',
            'time.required'=>'กรุณากรอกเวลา',
            'assignment.required'=>'กรุณาเลือกการมอบหมายงาน',
            'product.required'=>'กรุณาเลือกผลผลิต',
        ];
    }
}
