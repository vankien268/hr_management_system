<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnitUpdateRequest extends FormRequest
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
            'code' => 'required|max:50',
            'name' => 'required|max:50',
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
            'code.required' => trans('Tên viết tắt không bỏ trống.'),
            'code.max' => trans('Tên viết tắt không quá 50 ký tự.'),
            'name.required' => trans('Tên ngân hàng không bỏ trống.'),
            'name.max' => trans('Tên ngân hàng không quá 50 ký tự.'),
            'note.max' => trans('Ghi chú không quá 100 ký tự.'),
            'status.required' => trans('Chọn trạng thái đơn vị.')
        ];
    }
}
