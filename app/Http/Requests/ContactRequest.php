<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'contact_name' => 'required|max:255',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'required|max:25',
            'address' => 'nullable|max:256',
            'contact_message' => 'required|max:500',
        ];
    }

    public function attributes()
    {
        return [
            'contact_name' => 'Họ tên',
            'contact_email' => 'Email',
            'contact_phone' => 'Số điện thoại',
            'address' => 'Địa chỉ',
            'contact_message' => 'Lời nhắn',
        ];
    }
}