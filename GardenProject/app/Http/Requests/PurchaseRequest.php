<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
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
            'date_order'=>'required',
            'date_pay'=>'required',
            'date_get'=>'required',
            'time_order'=>'required',
            'time_pay'=>'required',
            'time_get'=>'required',
            'status'=>'required',
            'shop'=>'required',
        ];
    }
    public function messages() {
        return [
            'date_order.required'=>'กรุณากรอกวันที่สั่ง',
            'date_pay.required'=>'กรุณากรอกวันที่จ่าย',
            'date_get.required'=>'กรุณากรอกวันที่รับ',
            'time_order.required'=>'กรุณากรอกเวลาสั่ง',
            'time_pay.required'=>'กรุณากรอกเวลาจ่าย',
            'time_get.required'=>'กรุณากรอกเวลารับ',
            'status.required'=>'กรุณาเลือกสถานะ',
            'shop.required'=>'กรุณาเลือกร้านค้า',
        ];
    }
}
