<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HrmContractStoreRequest extends FormRequest
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
            'contract_code' => 'required|max:100',
            'contract_name' => 'required|max:100',
            'contract_type_id' => 'required',
            'register_date' => 'required',
            'time_limited' => 'nullable|max:100',
            'contact_id' => 'required',
            'effective_date' => 'required',
            'expiration_date' => 'required',
            'department_id' => 'required',
            'work_type' => 'nullable|max:100',
            'basic_salary' => 'required',
            'signer_department_id' => 'required|integer',
            'signer_user_id' => 'required|integer',
            'note' => 'nullable|string|max:200',
        ];
    }

    public function messages()
    {
        return [
            'contract_code.required' => 'Mã hợp đồng không bỏ trống.',
            'contract_name.required' => 'Tên hợp đồng không bỏ trống.',
            'contract_type_id.required' => 'Loại hợp đồng không bỏ trống.',
            'register_date.required' => 'Ngày tạo hợp đồng không bỏ trống.',
            'effective_date.required' => 'Ngày bắt đầu hiệu lực hợp đồng không bỏ trống.',
            'expiration_date.required' => 'Ngày kết thúc hiệu lực hợp đồng không bỏ trống.',
            'basic_salary.required' => 'Luương cơ bản không bỏ trống.',
            'contact_id.required' => 'Tên nhân viên không bỏ trống.',
            'signer_user_id.required' => 'Tên nhân viên không bỏ trống.',
            'department_id.required' => 'Bộ phận không bỏ trống.',
            'signer_department_id.required' => 'Bộ phận không bỏ trống.',
            'contract_code.max' => 'Mã hợp đồng không quá 100 ký tự.',
            'contract_name.max' => 'Tên hợp đồng không quá 100 ký tự.',
            'work_type.max' => 'Hình thức làm việc không quá 100 ký tự.',
            'note.max' => 'Hình thức làm việc không quá 200 ký tự.',
        ];
    }
}
