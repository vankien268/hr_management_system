<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\RequiredIf;
use App\Repositories\Interfaces\ICustomerRepository;
use App\Repositories\Interfaces\ISystemStatusRepository;

class StoreCustomerRequest extends FormRequest
{
    protected $customerRepository;
    protected $systemStatusRepository;

    public function __construct(ICustomerRepository $customerRepository, ISystemStatusRepository $systemStatusRepository)
    {
        $this->customerRepository = $customerRepository;
        $this->systemStatusRepository = $systemStatusRepository;
    }
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
            'code' => [
                'required',
                function($attribute, $value, $fail){
                    if($value === null){
                        return;
                    }
                    $checkCodeUnique = $this->customerRepository->model()->where('code', 'like', $value)->first();
                    if($checkCodeUnique){
                        return $fail(trans('Mã phải là duy nhất.'));
                    }
                    if(strlen($value) > 15){
                        return $fail(trans('Trường dữ liệu tối đa :size kí tự.', ['size' => 20]));
                    }
                }
            ],
            'name' => [
                'required',
                function($attribute, $value, $fail){
                    if($value === null){
                        return;
                    }
                    if(strlen($value) > 200){
                        return $fail(trans('Trường dữ liệu tối đa :size kí tự.', ['size' => 200]));
                    }
                }
            ],
            'tax_code' => [
                function($attribute, $value, $fail){
                    if($value === null){
                        return;
                    }
                    $checkTaxCodeUnique = $this->customerRepository->model()->where('tax_code', 'like', $value)->first();
                    if($checkTaxCodeUnique){
                        return $fail(trans('Mã số thuế đã tồn tại.'));
                    }
                    if(strlen($value) > 13){
                        return $fail(trans('Trường dữ liệu tối đa :size kí tự.', ['size' => 13]));
                    }
                }
            ],
            'address' => [
                function($attribute, $value, $fail){
                    if($value === null){
                        return;
                    }
                    if(strlen($value) > 200){
                        return $fail(trans('Trường dữ liệu tối đa :size kí tự.', ['size' => 200]));
                    }
                }
            ],
            // 'city_id',
            // 'district_id',
            // 'ward_id',
            'representative_name' => [
                'required',
                function($attribute, $value, $fail){
                    if($value === null){
                        return;
                    }
                    if(strlen($value) > 30){
                        return $fail(trans('Trường dữ liệu tối đa :size kí tự.', ['size' => 30]));
                    }
                }
            ],
            'representative_phone' => ['nullable','regex:/^[0-9]+$/', function($attribute, $value, $fail) {
                if(strlen($value) > 15) {
                    return $fail(trans('SĐT người đại diện không quá 15 ký tự.'));
                }
            }],
            'representative_email' => [
                // 'required',
                function($attribute, $value, $fail){
                    if($value === null){
                        return;
                    }
                    if(strlen($value) > 50){
                        return $fail(trans('Trường dữ liệu tối đa :size kí tự.', ['size' => 50]));
                    }
                    if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        return $fail(trans("Email không đúng định dạng."));
                    }

                }
            ],
            'status_id' => [
                'required',
                function($attribute, $value, $fail){
                    if($value === null){
                        return;
                    }
                    if(!is_numeric($value)){
                        return $fail(trans('Trạng thái không tồn tại.'));
                    }
                    $checkExistStatus = $this->systemStatusRepository->find($value);
                    if(!$checkExistStatus){
                        return $fail(trans('Trạng thái không tồn tại.'));
                    }
                    if($checkExistStatus->status == false){
                        return $fail(trans('Trạng thái không tồn tại.'));
                    }
                }
            ],
            'bank_username' => [
                new RequiredIf(isset($requestData['bank_id'])),
                function($attribute, $value, $fail){
                    if($value === null){
                        return;
                    }
                    if(strlen($value) > 200){
                        return $fail(trans('Trường dữ liệu tối đa :size kí tự.', ['size' => 200]));
                    }
                }
            ],
            'bank_number' => [
                new RequiredIf(isset($requestData['bank_id'])),
                function($attribute, $value, $fail){
                    if($value === null){
                        return;
                    }
                    if(!is_numeric($value)){
                        return $fail(trans("Trường dữ liệu phải là định dạng số."));
                    }
                    if(strlen($value) > 30){
                        return $fail(trans('Trường dữ liệu tối đa :size kí tự.', ['size' => 30]));
                    }
                }
            ],
            'bank_id' => [
                function($attribute, $value, $fail){
                    if($value === null){
                        return;
                    }
                    if(!is_numeric($value)){
                        return $fail(trans("Giá trị không hợp lệ."));
                    }
                }
            ],
            'note' => [
                function($attribute, $value, $fail){
                    if($value === null){
                        return;
                    }
                    if(strlen($value) > 200){
                        return $fail(trans('Trường dữ liệu tối đa :size kí tự.', ['size' => 200]));
                    }
                }
            ],
            'customer_type' => [
                function($attribute, $value, $fail){
                    if($value === null){
                        return;
                    }
                    if(!is_numeric($value) || ($value != 0 && $value != 1)){
                        return $fail(trans("Giá trị không hợp lệ."));
                    }
                }
            ],
            'user_id' => ['required', 'numeric', 'exists:users,id']
        ];
    }

    public function messages()
    {
        return [
            'code.required' => trans('Mã không được để trống.'),
            'name.required' => trans('Tên không được để trống.'),
            'representative_name.required' => trans('Tên người đại diện không được để trống.'),
            // 'representative_phone.required' => trans('Số điện thoại người đại diện không được để trống.'),
            'representative_phone.regex' => trans('SĐT người đại diện không đúng định dạng !'),

            'representative_email.required' => trans('Email người đại diện không được để trống.'),
            'status_id.required' => trans('Trạng thái không được để trống.'),
            'bank_number.required' => trans('Số tài khoản ngân hàng không được để trống.'),
            'bank_username.required' => trans('Tên tài khoản ngân hàng không được để trống.'),

            'user_id.required' => trans('Người phụ trách không bỏ trống.'),
            'user_id.numeric' => trans('Người phụ trách không hợp lệ.'),
            'user_id.exists' => trans('Người phụ trách không tồn tại.'),


        ];
    }
}
