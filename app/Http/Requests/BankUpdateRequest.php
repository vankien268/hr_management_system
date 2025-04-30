<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankUpdateRequest extends FormRequest
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
            'def_name' => 'required|max:30',
            'name' => 'required|max:100',
            'note' => 'nullable|max:100',
            'status' => ['required', function($attribute, $value, $fail) {
                if(!in_array($value, [0,1])) {
                    return $fail(trans('Trạng thái sử dụng không hợp lệ !'));
                }
            }],
        ];
    }

    public function messages()
    {
        return [
            'def_name.required' => trans('Tên viết tắt không bỏ trống.'),
            'def_name.max' => trans('Tên viết tắt không quá 30 ký tự.'),
            'name.required' => trans('Tên ngân hàng không bỏ trống.'),
            'name.max' => trans('Tên ngân hàng không quá 100 ký tự.'),
            'note.max' => trans('Ghi chú không quá 100 ký tự.'),
            'status.required' => trans('Chọn trạng thái ngân hàng.')
        ];
    }
}
