<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|min:5|max:20',
            'password' => 'required|min:6'
        ];
    }

    /**
     * customize msg error
     * @return array
     */
    public function messages()
    {
        return [
            'username.required' => 'Tên tài khoản không được để trống',
            'username.min' => 'Tên tài khoản chưa đủ 5 kí tự',
            'username.max' => 'Tên tài khoản không vượt quá 20 ký tự',
            'password.required' => 'Mật khẩu không được để trống',
            'password.min' => 'Mật khẩu chưa đủ 6 kí tự',
        ];
    }
}
