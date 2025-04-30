<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentUpdateRequest extends FormRequest
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
            // 'code' => ['required', 'unique:departments,code', 'max:20', 'regex:/^[0-9A-Z.\_]+$/'],
            'name' => 'required|max:50',
            'note' => 'nullable|max:80',
            'status' => ['required', function($attribute, $value, $fail) {
                if(!in_array($value, [0,1])) {
                    return $fail(trans('Trạng thái sử dụng không hợp lệ !'));
                }
            }],
            'parent_id' => ['nullable','numeric','exists:departments,id']
        ];
    }

    public function messages()
    {
        return [
            // 'code.required' => trans('Mã bộ phận không bỏ trống'),
            // 'code.unique' => trans('Mã bộ phận đã tồn tại'),
            // 'code.max' => trans('Mã bộ phận không quá 20 ký tự'),
            // 'code.regex' => trans('Mã bộ phận phải là số hoặc chữ hoặc cả số,chữ'),
            'name.required' => trans('Tên bộ phận không bỏ trống'),
            'name.max' => trans('Tên bộ phận không quá 50 ký tự'),
            'status.required' => trans('Chọn trạng thái bộ phận'),
            'parent_id.numeric' => trans('Bộ phận cha phải là số'),
            'parent_id.exists' => trans('Bộ phận cha không tồn tại'),
            'note.max' => trans('Ghi chú không vượt quá 80 ký tự.')
        ];
    }
}
