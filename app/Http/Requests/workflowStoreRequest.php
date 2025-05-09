<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class workflowStoreRequest extends FormRequest
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
            'workflow_name' => 'required|string',
            'dept_ids' => 'nullable|array',
            'description' => 'nullable|string',
            'workflow_type' => 'required|string',
            'approver_type' => 'required|string',
            'approver_ids' => 'required|array',
        ];
    }

    public function messages()
    {
        return [
            'workflow_name.required' => 'Tên quy trình không bỏ trống.',
            'workflow_type.required' => 'Loại quy trình không bỏ trống.',
            'approver_ids.required' => 'Người duyệt không bỏ trống.'
        ];
    }
}
