<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\RequiredIf;

class searchDeploymentScheduleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        $requestData = $this->all();
        return [
            'from_date' => ['nullable', new RequiredIf(isset($requestData['to_date']) && $requestData['to_date'])],
            'to_date' => ['nullable', new RequiredIf(isset($requestData['from_date']) && $requestData['from_date']), 'after_or_equal:from_date']
        ];
    }

    public function messages()
    {
        return [
            'from_date.required' => trans('Trường dữ liệu không được bỏ trống.'),
            'to_date.required' => trans('Trường dữ liệu không được bỏ trống.'),
            'to_date.after_or_equal' => trans('Ngày đến phải lớn hơn hoặc bằng trường từ ngày.')
        ];
    }
}
