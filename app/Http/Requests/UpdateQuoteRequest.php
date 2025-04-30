<?php

namespace App\Http\Requests;

use App\Enums\StatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use App\Repositories\Interfaces\IQuoteRepository;
use App\Repositories\Interfaces\IContractTypeRepository;

class UpdateQuoteRequest extends FormRequest
{
    protected $contractTypeRepository;
    protected $quoteRepository;
    /**
     * Summary of __construct
     * @param \App\Repositories\Interfaces\ISystemStatusRepository $systemStatusRepository
     */
    public function __construct(IContractTypeRepository $contractTypeRepository, IQuoteRepository $quoteRepository)
    {
        $this->contractTypeRepository = $contractTypeRepository;
        $this->quoteRepository = $quoteRepository;
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
        $quoteId = $this->route('api');
        $quote = $this->quoteRepository->find($quoteId);
        return [
            'title' => [
                'required',
                function($attribute, $value, $fail){
                    if($value === null){
                        return;
                    }
                    if(strlen($value) > 80){
                        return $fail(trans('Trường dữ liệu tối đa :size kí tự.', ['size' => 80]));
                    }
                }
            ],
            'contract_type_id' => [
                'required',
                function($att, $val, $fail) use($quote){
                    if($val === null || !$quote){
                        return;
                    }
                    if($quote->contract_type_id == $val){
                        return;
                    }
                    if(!is_numeric($val)){
                        return $fail(trans('Loại hợp đồng không tồn tại hoặc đã ngừng sử dụng.'));
                    }
                    $contractType = $this->contractTypeRepository->find($val);
                    if(!$contractType || $contractType->status == StatusEnum::STOP_USING){
                        return $fail(trans('Loại hợp đồng không tồn tại hoặc đã ngừng sử dụng.'));
                    }
                }
            ],
            'project_id' => [
                'required'
            ],
            'customer_id' => [
                'required'
            ],
            'approve_id' => [
                'required'
            ],
            'quote_date'=> [
                'required'
            ],
            'receiver' => [
                function($attribute, $value, $fail){
                    if($value === null){
                        return;
                    }
                    if(strlen($value) > 30){
                        return $fail(trans('Trường dữ liệu tối đa :size kí tự.', ['size' => 30]));
                    }
                }
            ],
            'email' => [
                function($attribute, $value, $fail){
                    if($value === null){
                        return;
                    }
                    if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        return $fail(trans("Email không đúng định dạng."));
                    }
                    if(strlen($value) > 100){
                        return $fail(trans('Trường dữ liệu tối đa :size kí tự.', ['size' => 100]));
                    }
                }
            ],
            'phone' => [
                function($attribute, $value, $fail){
                    if($value === null){
                        return;
                    }
                    if(strlen($value) > 10){
                        return $fail(trans('Trường dữ liệu tối đa :size kí tự.', ['size' => 10]));
                    }
                }
            ],
            'note' => ['max:400',
                function($attribute, $value, $fail){
                    if($value === null){
                        return;
                    }
                    // if(strlen($value) > 400){
                    //     return $fail(trans('Trường dữ liệu tối đa :size kí tự.', ['size' => 400]));
                    // }
                }
            ],
            'details.data.*.product_id' => [
                'required',
            ],
            'details.data.*.quantity' => [
                'required',
                function($attribute, $value, $fail){
                    if($value === null){
                        return;
                    }
                    if($value <= 0){
                        return $fail(trans('Số lượng sản phẩm phải lớn hơn 0.'));
                    }
                }
            ]
        ];
    }
    public function messages()
    {
        return [
            'title.required' => trans('Trường dữ liệu không được để trống.'),
            'contract_type_id.required' => trans('Trường dữ liệu không được để trống.'),
            'project_id.required' => trans('Trường dữ liệu không được để trống.'),
            'customer_id.required' => trans('Trường dữ liệu không được để trống.'),
            'approve_id.required' => trans('Trường dữ liệu không được để trống.'),
            'quote_date.required' => trans('Trường dữ liệu không được để trống.'),
            'details.data.*.product_id.required' => trans('Sản phẩm không được để trống.'),
            'details.data.*.quantity.required' => trans('Số lượng sản phẩm không được để trống.'),
            'note.max' => trans('Lưu ý không quá 400 ký tự.')

        ];
    }

}
