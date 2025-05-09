<?php

namespace App\Http\Requests;

use App\Models\Department;
use Illuminate\Foundation\Http\FormRequest;

class HrmContactUpdateRequest extends FormRequest
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
            'contact_code' => 'required|max:100',
            'full_name' =>  'required|min:5|max:100',
            'contact_mobile' =>'required|regex:/^[0-9]+$/',
            'contact_mobile_2' =>'nullable|regex:/^[0-9]+$/',
            'relative_phone_number' =>'nullable|regex:/^[0-9]+$/',
            'contact_email' => 'required|email|regex:/(.+)@(.+)\.(.+)/i|max:50',

            'department_id' => ['required', function($attribute, $value, $fail){
                $departments = Department::select('id')->where('status', 1)->get()->toArray();
                if(!is_numeric($value)) {
                    return $fail(trans('Bộ phận không đúng định dạng !'));
                }
                if(!in_array($value, array_column($departments, 'id'))) {
                    return $fail(trans('Bộ phận này không đúng !'));
                }
            }],
        ];
    }

    public function messages()
    {
       return [
         'full_name.required' =>'Họ tên nhân sự không bỏ trống.',
         'full_name.min' =>'Họ tên nhân sự không lớn hơn 5 ký tự.',
         'contact_code.required' =>'Mã nhân sự không bỏ trống.',
         'contact_code.max' =>'Mã nhân sự không quá 100 ký tự.',
         'contact_mobile.max' =>'Số điện thoại không quá 20 ký tự.',
         'full_name.max' =>'Họ tên nhân sự không quá 100 ký tự.',
         'department_id.required' =>'Bộ phận không bỏ trống.',
         'contact_mobile.required' =>'Số điện thoại không bỏ trống.',

         'contact_email.required' =>'Email không bỏ trống.',
         'contact_email.email' =>'Email không đúng định dạng.',
         'contact_email.regex' =>'Email không đúng định dạng.',
         'contact_email.max' =>'Email không quá 50 ký tự.',

         'contact_mobile.digits' =>'Số điện thoại không quá 15 ký tự.',
         'contact_mobile_2.digits' =>'Số điện thoại không quá 15 ký tự.',
         'relative_phone_number.digits' =>'Số điện thoại không quá 15 ký tự.',
       ];
    }
}
