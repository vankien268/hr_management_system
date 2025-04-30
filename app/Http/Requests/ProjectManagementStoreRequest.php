<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectManagementStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules()
    {
        return [
            'project.data' => 'required',
            'project.data.*.code' => ['required', 'unique:projects,code', 'max:30', 'regex:/^[0-9A-Z.\_]+$/'],
            'project.data.*.name' => ['required', 'max:100'],
            'project.data.*.customer_id' => ['required', 'numeric', 'exists:customers,id'],
            'project.data.*.city_id' => ['required', 'numeric', 'exists:cities,id'],
            'project.data.*.status_id' => ['required', 'numeric','exists:system_statuses,id'],
            'project.data.*.description' => ['nullable', 'max:100'],
            'project.data.*.project_type_id' => ['required', 'numeric','exists:project_types,id'],

            'contact.data' => 'required',
            'contact.data.*.name' => ['required', 'max:50'],
            'contact.data.*.phone' => ['required','regex:/^[0-9]+$/','digits:10'],
            'contact.data.*.email' => 'required|email|regex:/(.+)@(.+)\.(.+)/i|max:50',
            'contact.data.*.position' => ['required', 'max:50'],
            'contact.data.*.note' => ['nullable', 'max:100'],
            'contact.data.*.status' => ['required',function($attribute, $value, $fail) {
                $statuses = [0, 1];
                if(!in_array($value, $statuses)) {
                    return $fail(trans('Trạng thái không hợp lệ !'));
                }
            }],

            'user.data' => 'required',
            'user.data.*.user_id' => ['required', 'numeric', 'exists:users,id'],
            'user.data.*.note' => ['nullable', 'max:100']
        ];
    }

    public function messages()
    {
        return [
            // dự án
            'project.data' => trans('Dữ liệu về dự án không tồn tại.'),
            'project.data.*.code.required' => trans('Mã dự án không bỏ trống.'),
            'project.data.*.code.unique' => trans('Mã dự án đã tồn tại.'),
            'project.data.*.code.max' => trans('Mã dự án không quá 30 ký tự.'),
            'project.data.*.code.regex' => trans('Mã dự án phải là số hoặc chữ, không chứ ký tự đặc biệt.'),
            'project.data.*.name.required' => trans('Tên dự án không bỏ trống.'),
            'project.data.*.name.max' => trans('Tên dự án không quá 100 ký tự.'),
            'project.data.*.customer_id.required' => trans('Khách hàng không bỏ trống.'),
            'project.data.*.customer_id.numeric' => trans('Khách hàng không hợp lệ.'),
            'project.data.*.customer_id.exists' => trans('Khách hàng không tồn tại.'),
            'project.data.*.city_id.required' => trans('Tỉnh/thành phố không bỏ trống.'),
            'project.data.*.city_id.numeric' => trans('Tỉnh/thành phố không hợp lệ.'),
            'project.data.*.city_id.exists' => trans('Tỉnh/thành phố không tồn tại.'),
            'project.data.*.status_id.required' => trans('Trạng thái dự án không bỏ trống.'),
            'project.data.*.status_id.numeric' => trans('Trạng thái dự án không hợp lệ.'),
            'project.data.*.status_id.exists' => trans('Trạng thái dự án không tồn tại.'),
            'project.data.*.description.max' => trans('Mô tả không quá 100 ký tự.'),

            'project.data.*.project_type_id.required' => trans('Loại dự án không bỏ trống.'),
            'project.data.*.project_type_id.numeric' => trans('Loại dự án không hợp lệ.'),
            'project.data.*.project_type_id.exists' => trans('Loại dự án không tồn tại.'),

            // // người đại diện
            'contact.data' => trans('Dữ liệu về người đại diện không tồn tại.'),
            'contact.data.*.name.required' => trans('Tên người đại diện không bỏ trống.'),
            'contact.data.*.name.max' => trans('Tên người đại diện không quá 50 ký tự.'),

            'contact.data.*.phone.required' => trans('Số điện thoại người đại diện không bỏ trống.'),
            'contact.data.*.phone.regex' => trans('Số điện thoại không đúng định dạng.'),
            'contact.data.*.phone.digits' => trans('Số điện thoại phải là 10 số.'),

            'contact.data.*.email.required' => trans('Email người đại diện không bỏ trống.'),
            'contact.data.*.email.email' => trans('Email người đại diện không đúng định dạng.'),
            'contact.data.*.email.regex' => trans('Email người đại diện không đúng định dạng.'),
            'contact.data.*.email.max' => trans('Email người đại diện không quá 50 ký tự.'),

            'contact.data.*.position.required' => trans('Chức vụ không được bỏ trống.'),
            'contact.data.*.position.max' => trans('Chức vụ không quá 50 ký tự.'),

            'contact.data.*.note.max' => trans('Ghi chú không quá 100 ký tự.'),
            'contact.data.*.status.required' => trans('Trạng thái người đại diện không bỏ trống.'),

            // // người dùng phụ trách
            'user.data' => trans('Dữ liệu về người phụ trách không tồn tại.'),
            'user.data.*.user_id.required' => trans('Người phụ trách không bỏ trống.'),
            'user.data.*.user_id.numeric' => trans('Người phụ trách không hợp lệ.'),
            'user.data.*.user_id.exists' => trans('Người phụ trách không tồn tại.'),
            'user.data.*.note.max' => trans('Ghi chú không quá 100 ký tự.'),
        ];
    }
}
