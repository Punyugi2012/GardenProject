<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseDetailRequest extends FormRequest
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
            'total_money'=>'required',
            'item'=>'required'
        ];
    }
    public function messages() {
        return [
            'amount.required'=>'กรุณากรอกจำนวน',
            'total_money.required'=>'กรุณากรอกจำนวนเงินรวม',
            'item.required'=>'กรุณาเลือกวัตถุดิบ'
        ];
    }
}
