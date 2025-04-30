<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactStoreRequest extends FormRequest
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
            'contacts.*.name' => ['required', 'max:50'],
            'contacts.*.phone' => ['required','regex:/^[0-9]+$/','digits:10'],
            'contacts.*.email' => 'required|email|regex:/(.+)@(.+)\.(.+)/i|max:50',
            'contacts.*.position' => ['required', 'max:50'],
            'contacts.*.pivot.note' => ['nullable', 'max:100'],
            // trạng thái contact theo dự án
            'contacts.*.pivot.status' => ['required',function($attribute, $value, $fail) {
                $statuses = [0, 1];
                if(!in_array($value, $statuses)) {
                    return $fail(trans('Trạng thái không hợp lệ !'));
                }
            }],
            'project_id' => ['required', 'numeric', 'exists:projects,id'],
            'customer_id' => ['required', 'numeric', 'exists:customers,id']
        ];
    }

    public function messages()
    {
        return [
            'contacts.*.name.required' => trans('Tên người đại diện không bỏ trống.'),
            'contacts.*.name.max' => trans('Tên người đại diện không quá 50 ký tự.'),

            'contacts.*.phone.required' => trans('Số điện thoại người đại diện không bỏ trống.'),
            'contacts.*.phone.regex' => trans('Số điện thoại không đúng định dạng.'),
            'contacts.*.phone.digits' => trans('Số điện thoại phải là 10 số.'),

            'contacts.*.email.required' => trans('Email người đại diện không bỏ trống.'),
            'contacts.*.email.email' => trans('Email người đại diện không đúng định dạng.'),
            'contacts.*.email.regex' => trans('Email người đại diện không đúng định dạng.'),
            'contacts.*.email.max' => trans('Email người đại diện không quá 50 ký tự.'),

            'contacts.*.position.required' => trans('Chức vụ không được bỏ trống.'),
            'contacts.*.position.max' => trans('Chức vụ không quá 50 ký tự.'),

            'contacts.*.pivot.note.max' => trans('Ghi chú không quá 100 ký tự.'),
            'contacts.*.pivot.status.required' => trans('Trạng thái người đại diện không bỏ trống.'),

            'project_id.required' => trans('Mã dự án không bỏ trống.'),
            'project_id.numeric' => trans('Mã dự án không hợp lệ.'),
            'project_id.exists' => trans('Mã dự án không tồn tại.'),

            'customer_id.required' => trans('Mã khách hàng không bỏ trống.'),
            'customer_id.numeric' => trans('Mã khách hàng không hợp lệ.'),
            'customer_id.exists' => trans('Mã khách hàng không tồn tại.'),
        ];
    }
}
