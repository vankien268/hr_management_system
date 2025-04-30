<?php

namespace App\Http\Requests;

use App\Models\ProjectType;
use Illuminate\Foundation\Http\FormRequest;

class ProjectTypeStoreRequest extends FormRequest
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
        $codes = ProjectType::whereNull('deleted_at')->get()->pluck('code')->toArray();
        return [
            'code' => ['required', 'max:20', 'regex:/^[0-9A-Z.\_]+$/',function($attribute, $value, $fail) use($codes){
                if(in_array($value,  $codes)) {
                    return $fail(trans('Mã loại dự án đã tồn tại.'));
                }
            }],
            'name' => 'required|max:50',
            'note' => 'nullable|max:80',
        ];
    }

    public function messages()
    {
        return [
            'code.required' => trans('Mã loại dự án không bỏ trống.'),
            'code.unique' => trans('Mã loại dự án đã tồn tại.'),
            'code.max' => trans('Mã loại dự án không quá 20 ký tự.'),
            'code.regex' => trans('Mã loại dự án phải là số hoặc chữ, không chứ ký tự đặc biệt.'),
            'name.required' => trans('Tên loại dự án không bỏ trống.'),
            'name.max' => trans('Tên loại dự án không quá 50 ký tự.'),
            'note.max' => trans('Ghi chú không quá 80 ký tự.')
        ];
    }
}
