<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AllowanceUpdateRequest extends FormRequest
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
            'allowance_name' => ['required', 'max:100'],
            'allowance_type' => ['required',  function($attribute, $value, $fail) {
                if(! in_array($value, [1,2,3])) {
                    return $fail(trans('Loại phụ cấp không hợp lệ.'));
                }
            }],
            'allowed_number_days' => 'nullable|integer',
            'allowance_amount' => 'nullable|integer',
            'description' => 'nullable|max:200',
            'status' => ['required', function($attribute, $value, $fail) {
                if(! in_array($value, [0,1])) {
                    return $fail(trans('Trạng thái sử dụng không hợp lệ.'));
                }
            }],
        ];
    }

    public function messages()
    {
        return [
            'allowance_name.required' => trans('Tên phụ cấp không bỏ trống.'),
            'allowance_name.max' => trans('Tên phụ cấp không quá 100 ký tự.'),
            'allowance_type.required' => trans('Loại phụ cấp không bỏ trống.'),
            'allowed_number_days.integer' => trans('Số ngày không đúng định dạng.'),
            'description.max' => trans('Mô tả không quá 200 ký tự.'),
            'status.required' => trans('Trạng thái sử dụng không bỏ trống.')
        ];
    }
}
