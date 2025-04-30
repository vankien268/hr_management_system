<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionProjectStoreRequest extends FormRequest
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
           'permissions.*.user_id' => ['required', 'exists:users,id', 'numeric'],
           'permissions.*.project_id' => ['required', 'exists:projects,id', 'numeric'],
           'project_id' => ['required', 'exists:projects,id', 'numeric']
        ];
    }

    public function messages()
    {
        return [
            'permissions.*.user_id.required' => trans('Người dùng không hợp lệ.'),
            'permissions.*.user_id.exists' => trans('Người dùng không hợp lệ.'),
            'permissions.*.user_id.numeric' => trans('Người dùng không hợp lệ.'),

            'permissions.*.project_id.required' => trans('Dự án không hợp lệ.'),
            'permissions.*.project_id.exists' => trans('Dự án không hợp lệ.'),
            'permissions.*.project_id.numeric' => trans('Dự án không hợp lệ.'),

            'project_id.required' => trans('Dự án không hợp lệ.'),
            'project_id.exists' => trans('Dự án không hợp lệ.'),
            'project_id.numeric' => trans('Dự án không hợp lệ.')
        ];
    }
}
