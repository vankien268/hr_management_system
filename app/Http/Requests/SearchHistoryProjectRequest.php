<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\RequiredIf;

class SearchHistoryProjectRequest extends FormRequest
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
        $requestData = $this->all();
        return [
            'from_hours' => ['nullable'],
            'to_hours' => ['nullable'],

            'from_date' => ['nullable', new RequiredIf(isset($requestData['to_date']) && $requestData['to_date']),
             new RequiredIf(isset($requestData['from_hours']) && $requestData['from_hours'])],

            'to_date' => ['nullable', new RequiredIf(isset($requestData['from_date']) && $requestData['from_date']), 'after_or_equal:from_date',
            new RequiredIf(isset($requestData['to_hours']) && $requestData['to_hours'])
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'from_date.required' => trans('Trường dữ liệu không được bỏ trống.'),
            'to_date.required' => trans('Trường dữ liệu không được bỏ trống.'),
            'to_date.after_or_equal' => trans('Ngày đến phải lớn hơn hoặc bằng trường từ ngày.')
        ];
    }
}
