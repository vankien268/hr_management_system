<?php

namespace App\Http\Requests;

use App\Models\Department;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
        $dataRequest = \request()->all();

        return [
            'name' => 'required|min:5|max:20',
            'password' => ['nullable','max:50','regex:/^.*(?=.{6,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[{[\]~`!%^&*=};:?><@$()#_]).*$/',
                function($attribute, $value, $fail){
                    $value =  trim($value);
                    if(str_contains($value, ' ')) {
                        return $fail(trans('Mật khẩu phải viết liền, từ 6 ký tự có ít nhất 1 chữ thường, 1 chữ hoa, 1 số và 1 ký tự đặc biệt'));
                    }
                }],
            'confirm_password' => ['nullable','required_with:password','max:50','same:password','regex:/^.*(?=.{6,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[{[\]~`!%^&*=};:?><@$()#_]).*$/',
                function($attribute, $value, $fail) use($dataRequest){
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
                if( $getCurrentYear - $getYear < 0 || $getCurrentYear - $getYear < 18) {
                    return $fail(trans('Ngày sinh phải từ 18 tuổi !'));
                }
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
            'username.required' => trans('Tên đăng nhập không được bỏ trống!'),
            'username.regex' => trans('Tên đăng nhập phải là cả chữ và số, không được có khoảng trắng, không viết hoa, viết liền không dấu'),
            'username.unique' => trans('Tên đăng nhập đã tồn tại!'),
            'username.between' => trans('Tên đăng nhập phải từ 5 ký tự và không quá 20 ký tự!'),
            'name.required' => trans('Tên người dùng không được bỏ trống!'),
            'name.max' => trans('Tên người dùng không quá 20 ký tự!'),
            'name.min' => trans('Tên người dùng tối thiểu 5 ký tự!'),
            'password.max' => trans('Mật khẩu nhập tối đa 50 ký tự!'),
            'password.regex' => trans('Mật khẩu phải viết liền, từ 6 ký tự có ít nhất 1 chữ thường, 1 chữ hoa, 1 số và 1 ký tự đặc biệt'),
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

            'confirm_password.required_with' => trans('Mật khẩu nhập lại không được bỏ trống!'),
            'confirm_password.max' => trans('Mật khẩu nhập lại nhập tối đa 50 ký tự!'),
            'confirm_password.same' => trans('Mật khẩu nhập lại không trùng!'),
            'confirm_password.regex' => trans('Mật khẩu nhập lại phải viết liền, từ 6 ký tự có ít nhất 1 chữ thường, 1 chữ hoa, 1 số và 1 ký tự đặc biệt!'),
        ];
    }
}
