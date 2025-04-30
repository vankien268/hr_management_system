<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProjectTypeUpdateRequest extends FormRequest
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
            'name' => 'required|max:50',
            'note' => 'nullable|max:80',
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
            // 'code.required' => trans('Mã loại dự án không bỏ trống.'),
            // 'code.unique' => trans('Mã loại dự án đã tồn tại.'),
            // 'code.max' => trans('Mã loại dự án không quá 20 ký tự.'),
            // 'code.regex' => trans('Mã loại dự án phải là số hoặc chữ, không chứ ký tự đặc biệt.'),
            'name.required' => trans('Tên loại dự án không bỏ trống.'),
            'name.max' => trans('Tên loại dự án không quá 50 ký tự.'),
            'status.required' => trans('Chọn trạng thái loại dự án.'),
            'note.max' => trans('Ghi chú không quá 80 ký tự.')
        ];
    }
}
