<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Repositories\Interfaces\IContractRepository;
use App\Repositories\Interfaces\ISystemStatusRepository;

class UpdateContractRequest extends FormRequest
{
    protected $contractRepository;
    protected $systemStatusRepository;
    public function __construct(IContractRepository $contractRepository, ISystemStatusRepository $systemStatusRepository)
    {
        $this->contractRepository = $contractRepository;
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
                'max:100',
                function ($attribute, $value, $fail) use($requestData){
                    if ($value === null) {
                        return;
                    }
                    $checkCodeUnique = $this->contractRepository->model()->where('code', 'like', $value)->first();
                    if ($checkCodeUnique && isset($requestData['id']) && $requestData['id'] != $checkCodeUnique->id) {
                        return $fail(trans('Mã phải là duy nhất.'));
                    }
                }
            ],
            'signing_date' => [
                'required',
            ],
            'project_id' => [
                'required',
            ],
            'customer_id' => [
                'required',
            ],
            'user_contractor_id' => [
                'required',
            ],
            'user_charge_id' => [
                'required',
            ],
            'customer_contractor' => [
                'required',
                'max:50'
            ],
            'contract_type_id' => [
                'required',
            ],
            'contract_value' => [
                'required',
                function($attribute, $value, $fail){
                    if($value === null){
                        return;
                    }
                    $value = str_replace('.','', $value);
                    if(!is_numeric($value)){
                        return $fail(trans('Trường dữ liệu phải là định dạng số.'));
                    }
                }
            ],
            'start_date' => [
                'required',
                function($attribute, $value, $fail) use($requestData){
                    if($value === null || !isset($requestData['signing_date'])){
                        return;
                    }
                    if($requestData['signing_date'] > $value){
                        return $fail(trans('Ngày bắt đầu thực hiện phải lớn hơn ngày kí hợp đồng.'));
                    }
                }
            ],
            'expiration_date' => [
                'required',
                function($attribute, $value, $fail) use($requestData){
                    if($value === null || !isset($requestData['start_date'])){
                        return;
                    }
                    if($requestData['start_date'] > $value){
                        return $fail(trans('Ngày hết hạn hợp đồng phải lớn hơn ngày bắt đầu thực hiện.'));
                    }
                }
            ],
            'hand_over_date' => [
                'required',
                function($attribute, $value, $fail) use($requestData){
                    if($value === null || !isset($requestData['expiration_date'])){
                        return;
                    }
                    if($requestData['start_date'] > $value){
                        return $fail(trans('Thời gian nghiệm thu hợp đồng phải lớn hơn ngày bắt đầu thực hiện hợp đồng.'));
                    }
                }
            ],
            'number_payment' => [
                'required',
            ],
            'warranty_time' => [
                'required',
                function($attribute, $value, $fail){
                    if($value === null){
                        return;
                    }
                    if(!is_numeric($value)){
                        return $fail(trans('Trường dữ liệu phải là định dạng số.'));
                    }
                    if($value < 3 || $value > 36){
                        return $fail(trans('Trường dữ liệu phải từ :min đến :max', ['min' => '3', 'max' => '36']));
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
            'note_contract' => [
                'max:100'
            ],

            'contract_modules.data.*.value' => [
                'required',
            ],
            'contract_modules.data.*.module' => [
                'required',
                'max:100'
            ],
            'contract_modules.data.*.note_module' => [
                'max:100'
            ],

            'annex_contracts.data.*.code' => [
                'required',
                'max:50'
            ],
            'annex_contracts.data.*.date' => [
                'required',
            ],
            'annex_contracts.data.*.description' => [
                'required',
                'max:100'
            ],

            // 'payment_details.data.*.payment_times' => [
            //     'required',
            // ],
            'payment_details.data.*.amount' => [
                'required',
            ],
            'payment_details.data.*.actual_amount' => [
                'nullable',
            ],
            'payment_details.data.*.payment_date' => [
                'nullable',
            ],
            'payment_details.data.*.expected_payment_date' => [
                'required',
            ],
            'payment_details.data.*.note' => [
                'max:100'
            ],
        ];
    }

    public function messages()
    {
        return [
            'code.required' => trans('Trường dữ liệu không được để trống.'),
            'signing_date.required' => trans('Trường dữ liệu không được để trống.'),
            'project_id.required' => trans('Trường dữ liệu không được để trống.'),
            'customer_id.required' => trans('Trường dữ liệu không được để trống.'),
            'user_contractor_id.required' => trans('Trường dữ liệu không được để trống.'),
            'user_charge_id.required' => trans('Trường dữ liệu không được để trống.'),
            'customer_contractor.required' => trans('Trường dữ liệu không được để trống.'),
            'contract_type_id.required' => trans('Trường dữ liệu không được để trống.'),
            'contract_value.required' => trans('Trường dữ liệu không được để trống.'),
            'start_date.required' => trans('Trường dữ liệu không được để trống.'),
            'expiration_date.required' => trans('Trường dữ liệu không được để trống.'),
            'hand_over_date.required' => trans('Trường dữ liệu không được để trống.'),
            'number_payment.required' => trans('Trường dữ liệu không được để trống.'),
            'warranty_time.required' => trans('Trường dữ liệu không được để trống.'),
            'status_id.required' => trans('Trường dữ liệu không được để trống.'),
            'note_contract.max' => trans('Trường dữ liệu tối đa :size kí tự.', ['size' => 100]),
            'contract_modules.data.*.value.required' => trans('Trường dữ liệu không được để trống.'),
            'contract_modules.data.*.module.required' => trans('Trường dữ liệu không được để trống.'),
            'annex_contracts.data.*.code.required' => trans('Trường dữ liệu không được để trống.'),
            'annex_contracts.data.*.date.required' => trans('Trường dữ liệu không được để trống.'),
            'annex_contracts.data.*.description.required' => trans('Trường dữ liệu không được để trống.'),
            'payment_details.data.*.payment_times.required' => trans('Trường dữ liệu không được để trống.'),
            'payment_details.data.*.amount.required' => trans('Trường dữ liệu không được để trống.'),
            // 'payment_details.data.*.actual_amount.required' => trans('Trường dữ liệu không được để trống.'),
            // 'payment_details.data.*.payment_date.required' => trans('Trường dữ liệu không được để trống.'),
            'payment_details.data.*.expected_payment_date.required' => trans('Trường dữ liệu không được để trống.'),
            'code.max' => trans('Trường dữ liệu tối đa :size kí tự.', ['size' => 100]),
            'customer_contractor.max' => trans('Trường dữ liệu tối đa :size kí tự.', ['size' => 50]),
            'contract_modules.data.*.module.max' => trans('Trường dữ liệu tối đa :size kí tự.', ['size' => 100]),
            'contract_modules.data.*.note_module.max' => trans('Trường dữ liệu tối đa :size kí tự.', ['size' => 100]),
            'annex_contracts.data.*.code.max' => trans('Trường dữ liệu tối đa :size kí tự.', ['size' => 50]),
            'annex_contracts.data.*.description.max' => trans('Trường dữ liệu tối đa :size kí tự.', ['size' => 100]),
            'payment_details.data.*.note.max' => trans('Trường dữ liệu tối đa :size kí tự.', ['size' => 100]),
        ];
    }
}
