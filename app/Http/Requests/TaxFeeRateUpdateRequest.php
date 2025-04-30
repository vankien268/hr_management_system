<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaxFeeRateUpdateRequest extends FormRequest
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
            'code' => 'required|max:50',
            'description' => 'required|max:50',
            'rate' => 'required',
            'type' => 'required',
            'note' => 'nullable|max:100',
            'status' => ['required', function($attribute, $value, $fail) {
                if(!in_array($value, [0,1])) {
                    return $fail(trans('Trạng thái sử dụng không hợp lệ !'));
                }
            }],
        ];
    }
    public function messages()
    {
        return [
            'code.required' => trans('Mã không bỏ trống.'),
            'code.max' => trans('Mã không quá 50 ký tự.'),
            'description.required' => trans('Mô tả không bỏ trống.'),
            'description.max' => trans('Mô tả không quá 50 ký tự.'),
            'rate.required' => trans('Tỉ lệ không bỏ trống.'),
            'type.required' => trans('Loại thuế/phí không bỏ trống.'),
            'note.max' => trans('Ghi chú không quá 100 ký tự.'),
            'status.required' => trans('Chọn trạng thái thuế/phí.'),
        ];
    }
}
