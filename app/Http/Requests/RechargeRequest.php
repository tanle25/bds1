<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RechargeRequest extends FormRequest
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
            'amount_of_money' => 'required|numeric|min:10000|max:1000000000',
            'customer_name' => 'required|max:256',
            'customer_email' => 'required|email|max:256',
            'customer_phone' => 'required|max:256',
            'customer_message' => 'required|max:256',
            'payment_method' => 'required',
            // 'bank_code' => 'required_if:payment_method,1',
        ];
    }

    public function attributes()
    {
        return [
            'amount_of_money' => 'Số tiền',
            'customer_name' => 'Tên khách hàng',
            'customer_email' => 'Email',
            'customer_phone' => 'Số điện thoại',
            'customer_message' => 'Lời nhắn',
            'payment_method' => 'Phương thức thanh toán',
            'bank_code' => 'Mã ngân hàng',
        ];
    }

    public function messages()
    {
        return [
            'bank_code.required_if' => 'Bạn vui lòng chọn mã ngân hàng đối với hình thức thanh toán Online!',
        ];
    }
}
