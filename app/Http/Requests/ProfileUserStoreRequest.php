<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class ProfileUserStoreRequest extends FormRequest
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
            'name' => 'required|min:5|max:20',
            'gender' => ['required', function($attribute, $value, $fail){
                if(!in_array($value, [0,1,2])) {
                    return $fail(trans('Giới tính không hợp lệ !'));
                }
            }],

            'phone' => 'required|regex:/^[0-9]+$/|digits:10',
            'email' => 'required|email|regex:/(.+)@(.+)\.(.+)/i|max:50',
            'birthday' => ['required', 'date_format:Y-m-d', function($attribute, $value, $fail) {
                $getYear = Carbon::createFromFormat('Y-m-d', $value)->format('Y');
                $getCurrentYear = Carbon::now()->year;
                if( $getCurrentYear - $getYear < 0 || $getCurrentYear - $getYear < 18) {
                    return $fail(trans('Ngày sinh phải từ 18 tuổi !'));
                }
            }],
            'skype' => ['nullable', 'max:50'],
            'avatar' => ['nullable','file', 'mimes:png,jpg', 'max:100']
        ];
    }

    public function messages()
    {
        return [
            'name.required' => trans('Tên người dùng không được bỏ trống !'),
            'name.max' => trans('Tên người dùng không quá 20 ký tự !'),
            'name.min' => trans('Tên người dùng tối thiểu 5 ký tự !'),
            'email.required' => trans('Email không được bỏ trống !'),
            'email.email' => trans('Email không đúng định dạng !'),
            'email.regex' => trans('Email không đúng định dạng !'),
            'email.max' => trans('Email không quá 50 ký tự !'),
            'phone.required' => trans('Số điện thoại không bỏ trống !'),
            'phone.digits' => trans('Số điện thoại phải là 10 số !'),
            'phone.regex' => trans('Số điện thoại không đúng định dạng !'),
            'gender.required' => trans('Giới tính không được bỏ trống !'),
            'birthday.required' => trans('Ngày sinh không bỏ trống !'),
            'birthday.date_format' => trans('Ngày sinh phải đúng định dạng Y-m-d !'),
            'avatar.file' => trans('Ảnh đại diện phải là file ảnh.'),
            'avatar.mimes' => trans('Ảnh đại diện phải phải là định dạng png,jpg.'),
            'avatar.max' => trans('Ảnh đại diện tối đa 100kb.'),
        ];
    }
}
