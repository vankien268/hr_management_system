<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InternalFundUpdateRequest extends FormRequest
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
            'internal_fund' => 'filled|numeric',
            'internal_fund_type' => 'nullable|string'
        ];
    }

    public function messages()
    {
        return [
            'internal_fund.numeric' => 'Số tiền quỹ nội bộ phải là kiểu số.',
            'internal_fund_type.string' => 'Loại quỹ nội bộ phải là chuỗi.',
        ];
    }
}
