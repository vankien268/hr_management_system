<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\RequiredIf;

class SearchNotificationRequest extends FormRequest
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
            'from_date_create' => ['nullable', 'date', new RequiredIf(isset($requestData['to_date_create']) && $requestData['to_date_create'])],
            'to_date_create' => ['nullable', 'date', new RequiredIf(isset($requestData['from_date_create']) && $requestData['from_date_create']),
            'after_or_equal:from_date_create'
          ],

            'from_date_expiration' => ['nullable', 'date', new RequiredIf(isset($requestData['to_date_expiration']) && $requestData['to_date_expiration'])],
            'to_date_expiration' => ['nullable', 'date', new RequiredIf(isset($requestData['from_date_expiration']) && $requestData['from_date_expiration']),
            'after_or_equal:from_date_expiration'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'from_date_create.required' => trans('Trường dữ liệu không được bỏ trống.'),
            'to_date_create.required' => trans('Trường dữ liệu không được bỏ trống.'),
            'to_date_create.after_or_equal' => trans('Ngày đến phải lớn hơn hoặc bằng trường từ ngày.'),

            'from_date_expiration.required' => trans('Trường dữ liệu không được bỏ trống.'),
            'to_date_expiration.required' => trans('Trường dữ liệu không được bỏ trống.'),
            'to_date_expiration.after_or_equal' => trans('Ngày đến phải lớn hơn hoặc bằng trường từ ngày.')
        ];
    }
}
