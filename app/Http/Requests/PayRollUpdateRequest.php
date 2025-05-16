<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PayRollUpdateRequest extends FormRequest
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
            'pay_roll_name' => 'required|string|max:100',
            'start_date' => 'required',
            'end_date' => 'required',
            'description' => 'nullable|string|max:200',

//            'pay_ranges.*.position_based_pay' => 'numeric',
//            'pay_ranges.*.person_based_pay' => 'numeric',
//            'pay_ranges.*.performance_based_pay' => 'numeric',
        ];
    }

    public function messages()
    {
        return [
            'pay_roll_name.required' => 'Tên bậc lương vị trí không bỏ trống.',
            'pay_roll_name.max' => 'Tên bậc lương vị trí không quá 100 ký tự.',
            'start_date.required' => 'Ngày có hiệu lực không bỏ trống.',
            'end_date.required' => 'Ngày hết hiệu lực không bỏ trống.',

            'pay_ranges.*.position_based_pay' => 'Lương P1 phải là kiểu số.',
            'pay_ranges.*.person_based_pay' => 'Lương P2 phải là kiểu số.',
            'pay_ranges.*.performance_based_pay' => 'Lương theo hiệu suất phải là kiểu số.',

        ];
    }
}
