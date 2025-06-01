<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class salaryStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'max:100'],
            'month' => ['required', 'numeric'],
            'year' => ['required', 'numeric'],
            'department_ids' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => trans('Tên bảng lương không bỏ trống.'),
            'month.required' => trans('Tháng không bỏ trống.'),
            'month.numeric' => trans('Tháng phải là số.'),
            'year.required' => trans('Năm không bỏ trống.'),
            'year.numeric' => trans('Năm phải là số.'),
            'department_ids.required' => trans('Bộ phận không bỏ trống.'),
        ];
    }
}
