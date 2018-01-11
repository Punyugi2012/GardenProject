<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClaimRequest extends FormRequest
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
            'date_claim'=>'required',
            'date_get'=>'required',
            'time_claim'=>'required',
            'time_get'=>'required',
            'purchase'=>'required'
        ];
    }
    public function messages()
    {
        return [
            'date_claim.required'=>'กรุณากรอกวันที่เคลม',
            'date_get.required'=>'กรุณากรอกวันที่รับ',
            'time_claim.required'=>'กรุณากรอกเวลาเคลม',
            'time_get.required'=>'กรุณากรอกเวลารับ',
            'purchase.required'=>'กรุณาเลือกการสั่งซื้อ'
        ];
    }
}
