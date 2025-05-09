<?php

namespace App\Http\Requests;

use App\Models\Department;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
            // 'code' => ['required', 'unique:users,code', 'max:20', 'regex:/^[0-9A-Z.\_]+$/'],
            'username' =>  ['required','regex:/^[a-z0-9]+$/','unique:users,username','between:5,20',
                // function($attribute, $value, $fail) {
                //     if(is_numeric($value)){
                //         return $fail(trans('Tên tài khoản phải gồm cả chữ và số, không có khoảng trắng, không viết hoa, viết liền không dấu !'));
                //     }
                //     // nếu value toàn là chữ
                //     $pattern = '/^[a-z]+$/';
                //     if (preg_match($pattern, $value)) {
                //         return $fail(trans('Tên tài khoản phải gồm cả chữ và số, không có khoảng trắng, không viết hoa, viết liền không dấu !'));
                //     }
                // }
            ],
            'name' => 'required|min:5|max:20',
            'password' => ['required','max:50','regex:/^.*(?=.{6,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[{[\]~`!%^&*=};:?><@$()#_]).*$/',
                function($attribute, $value, $fail){
                $value =  trim($value);
                if(str_contains($value, ' ')) {
                    return $fail(trans('Mật khẩu phải viết liền, từ 6 ký tự có ít nhất 1 chữ thường, 1 chữ hoa, 1 số và 1 ký tự đặc biệt !'));
                }
            }],
            'confirm_password' => ['required','max:50','same:password','regex:/^.*(?=.{6,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[{[\]~`!%^&*=};:?><@$()#_]).*$/',
                function($attribute, $value, $fail){
                    $value =  trim($value);
                    if(str_contains($value, ' ')) {
                        return $fail(trans('Mật khẩu nhập lại phải viết liền, từ 6 ký tự có ít nhất 1 chữ thường, 1 chữ hoa, 1 số và 1 ký tự đặc biệt!'));
                    }
                }],
            'email' => 'required|email|regex:/(.+)@(.+)\.(.+)/i|max:50',
            'gender' => ['required', function($attribute, $value, $fail){
                if(!in_array($value, [0,1,2])) {
                    return $fail(trans('Giới tính không hợp lệ !'));
                }
            }],
            'phone' => 'required|regex:/^[0-9]+$/|digits:10',
            'status' => ['required',function($attribute, $value, $fail) {
                $statuses = [0, 1];
                if(!in_array($value, $statuses)) {
                    return $fail(trans('Trạng thái không hợp lệ !'));
                }
            }],
            'birthday' => ['required', 'date_format:Y-m-d', function($attribute, $value, $fail) {
                $getYear = Carbon::createFromFormat('Y-m-d', $value)->format('Y');
                $getCurrentYear = Carbon::now()->year;
//                if( $getCurrentYear - $getYear < 0 || $getCurrentYear - $getYear < 18) {
//                    return $fail(trans('Ngày sinh phải từ 18 tuổi !'));
//                }
            }],
            'department_id' => ['required', function($attribute, $value, $fail){
                $departments = Department::select('id')->where('status', 1)->get()->toArray();
                if(!is_numeric($value)) {
                    return $fail(trans('Bộ phận không đúng định dạng !'));
                }
                if(!in_array($value, array_column($departments, 'id'))) {
                    return $fail(trans('Bộ phận này không đúng !'));
                }
            }],
            'roles.*.role_id' => ['required', 'numeric', 'exists:roles,id']
        ];
    }

    public function messages()
    {
        return [
            // 'code.required' => trans('Mã người dùng không bỏ trống !'),
            // 'code.unique' => trans('Mã người dùng đã tồn tại !'),
            // 'code.max' => trans('Mã người dùng không quá 20 ký tự !'),
            // 'code.regex' => trans('Mã người dùng phải là số hoặc chữ, không chứ ký tự đặc biệt !'),
            'username.required' => trans('Tên tài khoản không được bỏ trống!'),
            'username.regex' => trans('Tên tài khoản không có khoảng trắng, không viết hoa, viết liền không dấu!'),
            'username.unique' => trans('Tên tài khoản đã tồn tại!'),
            'username.between' => trans('Tên tài khoản phải từ 5 ký tự và không quá 20 ký tự!'),
            'name.required' => trans('Tên người dùng không được bỏ trống!'),
            'name.max' => trans('Tên người dùng không quá 20 ký tự!'),
            'name.min' => trans('Tên người dùng tối thiểu 5 ký tự!'),
            'password.required' => trans('Mật khẩu không được bỏ trống!'),
            'password.max' => trans('Mật khẩu nhập tối đa 50 ký tự!'),
            'password.regex' => trans('Mật khẩu phải viết liền, từ 6 ký tự có ít nhất 1 chữ thường, 1 chữ hoa, 1 số và 1 ký tự đặc biệt!'),

            'confirm_password.required' => trans('Mật khẩu nhập lại không được bỏ trống!'),
            'confirm_password.max' => trans('Mật khẩu nhập lại nhập tối đa 50 ký tự!'),
            'confirm_password.same' => trans('Mật khẩu nhập lại không trùng!'),
            'confirm_password.regex' => trans('Mật khẩu nhập lại phải viết liền, từ 6 ký tự có ít nhất 1 chữ thường, 1 chữ hoa, 1 số và 1 ký tự đặc biệt!'),

            'email.required' => trans('Email không được bỏ trống!'),
            'email.email' => trans('Email không đúng định dạng!'),
            'email.regex' => trans('Email không đúng định dạng!'),
            'email.max' => trans('Email không quá 50 ký tự!'),
            'phone.required' => trans('Số điện thoại không bỏ trống!'),
            'phone.digits' => trans('Số điện thoại phải là 10 số!'),
            'phone.regex' => trans('Số điện thoại không đúng định dạng!'),
            'gender.required' => trans('Giới tính không được bỏ trống!'),
            'status.required' => trans('Trạng thái không được bỏ trống!'),
            'birthday.required' => trans('Ngày sinh không bỏ trống!'),
            'birthday.date_format' => trans('Ngày sinh phải đúng định dạng Y-m-d!'),
            'department_id.required' => trans('Bộ phận không được bỏ trống!'),
            'roles.*.role_id.required' => trans('Nhóm quyền không bỏ trống.'),
            'roles.*.role_id.numeric' => trans('Nhóm quyền không hợp lệ.'),
            'roles.*.role_id.exists' => trans('Nhóm quyền không hợp lệ.'),
        ];
    }
}
