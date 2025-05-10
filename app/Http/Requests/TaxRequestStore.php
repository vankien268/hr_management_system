<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaxRequestStore extends FormRequest
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
            'tax_name' => 'required|string',
            'tax_income_from' => 'numeric',
            'tax_income_to' => 'numeric|gt:tax_income_from',
            'tax_rate' => 'numeric',
            'tax_reduction' => 'numeric',
        ];
    }

    public function messages()
    {
        return [
            'tax_name.required' => 'Tên thuế không bỏ trống.',
            'tax_income_from.numeric' => 'Số tiền từ phải là số.',
            'tax_income_to.numeric' => 'Số tiền đến phải là số.',
            'tax_rate.numeric' => 'Thuế suất phải là số.',
            'tax_reduction.numeric' => 'Giá trị tính phải là số.',
            'tax_income_to.gt' => 'Số tiền đến phải lớn hơn số tiền từ.',
        ];
    }
}
