<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkingShiftSettingUpdateRequest extends FormRequest
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
            'shift_title' => 'required|max:100',
            'attributes.work_number' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'shift_title.required' => 'Tên ca làm việc không bỏ trống.',
            'shift_title.max' => 'Tên ca làm việc không quá 100 ký tự.',
            'attributes.work_number.required' => 'Số công / ca làm việc không bỏ trống.',
            'attributes.work_number.work_number' => 'Số công / ca làm việc phải là số.'
        ];
    }
}
