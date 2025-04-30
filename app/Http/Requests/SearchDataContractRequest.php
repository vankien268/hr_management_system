<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\RequiredIf;

class SearchDataContractRequest extends FormRequest
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
        $requestData = $this->all();
        return [
            'warranty_time' => [
                function($attribute, $value, $fail){
                    if($value === null){
                        return;
                    }
                    if($value < 3 || $value > 36){
                        return $fail(trans('Trường dữ liệu phải từ :min đến :max', ['min' => '3', 'max' => '36']));
                    }
                }
            ],
            'signing_from'=> [
                new RequiredIf( isset($requestData['is_signing']) && in_array($requestData['is_signing'], ['true', 1])),
            ],
            'signing_to' => [
                new RequiredIf( isset($requestData['is_signing']) && in_array($requestData['is_signing'], ['true', 1])),
            ],
            'expiration_from'=> [
                new RequiredIf( isset($requestData['is_expiration']) && in_array($requestData['is_expiration'], ['true', 1])),
            ],
            'expiration_to' => [
                new RequiredIf( isset($requestData['is_expiration']) && in_array($requestData['is_expiration'], ['true', 1])),
            ],
        ];
    }
    public function messages()
    {
        return [
            'signing_from.required' => trans('Trường dữ liệu không được để trống.'),
            'signing_to.required' => trans('Trường dữ liệu không được để trống.'),
            'expiration_to.required' => trans('Trường dữ liệu không được để trống.'),
            'expiration_from.required' => trans('Trường dữ liệu không được để trống.'),
            'user_contractor_id.required' => trans('Trường dữ liệu không được để trống.'),
            'user_charge_id.required' => trans('Trường dữ liệu không được để trống.'),
            'customer_contractor.required' => trans('Trường dữ liệu không được để trống.'),
            'contract_type_id.required' => trans('Trường dữ liệu không được để trống.'),
            'contract_value.required' => trans('Trường dữ liệu không được để trống.'),
        ];
    }
}
