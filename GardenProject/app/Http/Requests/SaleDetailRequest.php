<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleDetailRequest extends FormRequest
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
            'price_per_product'=>'required',
            'product'=>'required'
        ];
    }
    public function messages()
    {
        return [
            'amount.required'=>'กรุณากรอกจำนวน',
            'price_per_product.required'=>'กรุณากรอกราคาต่อหน่วย',
            'product.required'=>'กรุณาเลือกผลผลิต'
        ];
    }
}
