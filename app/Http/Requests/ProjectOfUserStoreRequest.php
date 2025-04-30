<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectOfUserStoreRequest extends FormRequest
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
            'users.*.id' => ['required', 'numeric', 'exists:users,id'],
            'project_id' => ['required', 'numeric', 'exists:projects,id'],
            'users.*.pivot.note' => ['nullable', 'max:100']
        ];
    }

    public function messages()
    {
        return [
            'project_id.required' => trans('Mã dự án không bỏ trống.'),
            'project_id.numeric' => trans('Mã dự án không hợp lệ.'),
            'project_id.exists' => trans('Mã dự án không tồn tại.'),

            'users.*.id.required' => trans('Người phụ trách không bỏ trống.'),
            'users.*.id.numeric' => trans('Người phụ trách không hợp lệ.'),
            'users.*.id.exists' => trans('Người phụ trách không tồn tại.'),

            'users.*.pivot.note.max' => trans('Ghi chú không quá 100 ký tự.'),
        ];
    }
}
