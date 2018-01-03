<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
            'type'=>'required',
            'shop'=>'required'
        ];
    }
    public function messages()
    {
        return [
            'date'=>'กรุณากรอกวันที่',
            'time'=>'กรุณากรอกเวลา',
            'type'=>'กรุณาเลือกประเภท',
            'shop'=>'กรุณาเลือกร้านค้า'
        ];
    }
}
