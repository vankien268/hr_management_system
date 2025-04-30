<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleUpdateRequest extends FormRequest
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
            'name' => ['required','max:50'],
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
            'name.required' => trans('Tên nhóm quyền không được để trống.'),
            'name.unique' => trans('Tên nhóm quyền đã tồn tại trong hệ thống.'),
            'name.max' => trans('Tên nhóm quyền không vượt quá 50 kí tự.'),
            'status.required' => trans('Trạng thái không được bỏ trống.')
        ];
    }
}
