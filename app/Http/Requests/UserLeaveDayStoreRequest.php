<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserLeaveDayStoreRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'number_of_monthly_leave_days' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'number_of_monthly_leave_days.numeric' => 'Số ngày phép hàng tháng phải là kiểu số.',
            'number_of_monthly_leave_days.required' => 'Số ngày phép hàng tháng không bỏ trống.',
        ];
    }
}
