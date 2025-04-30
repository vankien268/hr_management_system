<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankStoreRequest extends FormRequest
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
            'def_name' => ['required', 'unique:banks,def_name', 'max:30', 'regex:/^[0-9A-Z.\_]+$/'],
            'name' => 'required|max:100',
            'note' => 'nullable|max:100',
        ];
    }

    public function messages()
    {
        return [
            'def_name.required' => trans('Tên viết tắt không bỏ trống.'),
            'def_name.unique' => trans('Tên viết tắt đã có.'),
            'def_name.max' => trans('Tên viết tắt không quá 30 ký tự.'),
            'def_name.regex' => trans('Tên viết tắt không chứa khoảng trắng, tiếng Việt không dấu.'),
            'name.required' => trans('Tên ngân hàng không bỏ trống.'),
            'name.max' => trans('Tên ngân hàng không quá 100 ký tự.'),
            'note.max' => trans('Ghi chú không quá 100 ký tự.')
        ];
    }
}
