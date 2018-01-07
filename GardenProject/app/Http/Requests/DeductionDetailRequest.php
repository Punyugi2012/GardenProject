<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeductionDetailRequest extends FormRequest
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
            'price'=>'required',
            'cause'=>'required',
            'amount'=>'required',
            'item'=>'required'
        ];
    }
    public function messages()
    {
        return [
            'price.required'=>'กรุณากรอกราคาที่คิด',
            'cause.required'=>'กรุณากรอกหมายเหตุ',
            'amount.required'=>'กรุณากรอกจำนวน',
            'item.required'=>'กรุณาเลือกวัตถุดิบ'
        ];
    }
}
