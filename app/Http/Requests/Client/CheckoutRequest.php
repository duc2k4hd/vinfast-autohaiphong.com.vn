<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'customer_name' => ['required', 'string', 'min:2', 'max:100'],
            'customer_phone' => ['required', 'string', 'regex:/^(0[3|5|7|8|9])+([0-9]{8})$/'],
            'customer_email' => ['nullable', 'email', 'max:150'],
            'customer_note' => ['nullable', 'string', 'max:1000'],
            'consent_accepted' => ['required', 'accepted'],
            'idempotency_key' => ['nullable', 'string', 'max:64'],
        ];
    }

    /**
     * Get custom error messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'customer_name.required' => 'Vui lòng nhập họ và tên của bạn.',
            'customer_phone.required' => 'Vui lòng cung cấp số điện thoại liên hệ.',
            'customer_phone.regex' => 'Số điện thoại không đúng định dạng (Ví dụ: 0988302882).',
            'consent_accepted.required' => 'Vui lòng xác nhận đồng ý với điều khoản thanh toán tiền mặt.',
            'consent_accepted.accepted' => 'Vui lòng xác nhận đồng ý với điều khoản thanh toán tiền mặt.',
        ];
    }
}

