<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentDetailRequest extends FormRequest
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
            'amount_money'=>'required',
            'purchase'=>'required'
        ];
    }
    public function messages()
    {
        return [
            'amount_money.required'=>'กรุณากรอกจำนวนเงิน',
            'purchase.required'=>'กรุณาเลือกการสั่งซื้อ'
        ];
    }
}
