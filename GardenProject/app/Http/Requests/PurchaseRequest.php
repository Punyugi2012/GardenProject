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
            'total_money'=>'required',
            'status'=>'required',
            'shop'=>'required',
        ];
    }
    public function messages() {
        return [
            'date_order'=>'กรุณากรอกวันที่สั่ง',
            'date_pay'=>'กรุณากรอกวันที่จ่าย',
            'date_get'=>'กรุณากรอกวันที่รับ',
            'time_order'=>'กรุณากรอกเวลาสั่ง',
            'time_pay'=>'กรุณากรอกเวลาจ่าย',
            'time_get'=>'กรุณากรอกเวลารับ',
            'total_money'=>'กรุณากรอกจำนวนเงินทั้งหมด',
            'status'=>'กรุณาเลือกสถานะ',
            'shop'=>'กรุณาเลือกร้านค้า',
        ];
    }
}
