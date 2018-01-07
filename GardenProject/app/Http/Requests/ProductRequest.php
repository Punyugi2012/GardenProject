<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name'=>'required',
            'price_per_product'=>'required',
            'amount_stock'=>'required'
        ];
    }
    public function messsages()
    {
        return [
            'name.required'=>'กรุณากรอกชื่อ',
            'price_per_product.required'=>'กรุณากรอกราคาต่อหน่วย',
            'amount_stock.required'=>'กรุณากรอกจำนวนในสต็อค'
        ];
    }
}
