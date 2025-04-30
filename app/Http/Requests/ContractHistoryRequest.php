<?php

namespace App\Http\Requests;
use App\Models\SystemStatus;
use Illuminate\Validation\Rules\RequiredIf;

use Illuminate\Foundation\Http\FormRequest;

class ContractHistoryRequest extends FormRequest
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
            'from_hour_history' => ['nullable'],
            'to_hour_history' => ['nullable'],

            'from_date_history' => ['nullable', new RequiredIf(isset($requestData['to_date_history']) && $requestData['to_date_history']),
             new RequiredIf(isset($requestData['from_hour_history']) && $requestData['from_hour_history'])],

            'to_date_history' => ['nullable', new RequiredIf(isset($requestData['from_date_history']) && $requestData['from_date_history']), 'after_or_equal:from_date_history',
            new RequiredIf(isset($requestData['to_hour_history']) && $requestData['to_hour_history'])
            ]
        ];
    }

    public function messages()
    {
        return [
            'from_date_history.required' => trans('Trường dữ liệu không được bỏ trống.'),
            'to_date_history.required' => trans('Trường dữ liệu không được bỏ trống.'),
            'to_date_history.after_or_equal' => trans('Ngày đến phải lớn hơn hoặc bằng trường từ ngày.')
        ];
    }
}
