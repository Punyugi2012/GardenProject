<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
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
            'type'=>'required',
            'name'=>'required',
            'amount'=>'required',
            'price_per_item'=>'required'
        ];
    }
    public function messages() {
        return [
            'type'=>'กรุณาเลือกประเภท',
            'name'=>'กรุณากรอกชื่อ',
            'amount'=>'กรุณากรอกจำนวน',
            'price_per_item'=>'กรุณากรอกราคาต่อชิ้น'
        ];
    }
}
