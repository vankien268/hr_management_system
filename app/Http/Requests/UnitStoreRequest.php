<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnitStoreRequest extends FormRequest
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
            'code' => ['required', 'unique:units,code', 'max:50', 'regex:/^[0-9A-Z.\_]+$/'],
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
            'code.unique' => trans('Tên viết tắt đã có.'),
            'code.max' => trans('Tên viết tắt không quá 50 ký tự.'),
            'code.regex' => trans('Tên viết tắt không chứa khoảng trắng, tiếng Việt không dấu.'),
            'name.required' => trans('Tên đơn vị không bỏ trống.'),
            'name.max' => trans('Tên đơn vị không quá 50 ký tự.'),
            'note.max' => trans('Ghi chú không quá 100 ký tự.'),
            'status.required' => trans('Trạng thái không được để trống.'),
        ];
    }
}
