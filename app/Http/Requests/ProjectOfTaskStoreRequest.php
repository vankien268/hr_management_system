<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectOfTaskStoreRequest extends FormRequest
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
            // 'tasks' => 'required',
            'tasks.*.date' => ['required', 'date_format:Y-m-d', 'before_or_equal:today'],
            'tasks.*.status_id' => ['required', 'numeric','exists:system_statuses,id'],
            'tasks.*.description' => ['required','max:200'],
            'tasks.*.note' => ['nullable','max:100'],
            'tasks.*.user_id' => ['required', 'numeric','exists:users,id'],
            'project_id' => ['required', 'numeric', 'exists:projects,id'],
        ];
    }

    public function messages()
    {
        return [
            // 'tasks.required' => trans('Dữ liệu không hợp lệ.'),
            'tasks.*.date.required' => trans('Ngày phát sinh nhật ký không bỏ trống.'),
            'tasks.*.date.date_format' => trans('Ngày phát sinh nhật ký phải đúng định dạng d/m/Y.'),
            'tasks.*.date.before_or_equal' => trans('Ngày phát sinh nhật ký phải là ngày hiện tại hoặc quá khứ.'),

            // 'task.*.user_id.required' => trans('Người thực hiện không bỏ trống.'),
            // 'task.*.user_id.numeric' => trans('Người thực hiện không hợp lệ.'),
            // 'task.*.user_id.exists' => trans('Người thực hiện không tồn tại.'),
            'tasks.*.description.required' => trans('Mô tả không bỏ trống.'),
            'tasks.*.description.max' => trans('Mô tả không quá 200 ký tự.'),
            'tasks.*.note.max' => trans('Ghi chú không quá 100 ký tự.'),

            'tasks.*.status_id.required' => trans('Trạng thái nhật ký không bỏ trống.'),
            'tasks.*.status_id.numeric' => trans('Trạng thái nhật ký không hợp lệ.'),
            'tasks.*.status_id.exists' => trans('Trạng thái nhật ký không tồn tại.'),

            'project_id.required' => trans('Mã dự án không bỏ trống.'),
            'project_id.numeric' => trans('Mã dự án không hợp lệ.'),
            'project_id.exists' => trans('Mã dự án không tồn tại.'),

            'tasks.*.user_id.required' => trans('Mã người dùng không bỏ trống.'),
            'tasks.*.user_id.numeric' => trans('Mã người dùng không hợp lệ.'),
            'tasks.*.user_id.exists' => trans('Mã người dùng không tồn tại.'),
        ];
    }
}
