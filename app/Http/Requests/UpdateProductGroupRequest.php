<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Repositories\Interfaces\IProductGroupRepository;

class UpdateProductGroupRequest extends FormRequest
{
    protected $productGroupRepository;
    public function __construct(IProductGroupRepository $productGroupRepository)
    {
        $this->productGroupRepository = $productGroupRepository;
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
        return [
            'name' => [
                'max:100',
                function($attribute, $value, $fail){
                    if($value === null){
                        return trans('Tên không được để trống.');
                    }
                }
            ],
            'note' => [
                'max:100'
            ],
            'tax_id' => [
                'required',
            ],
            'fee_id' => [
                'required',
            ]
        ];
    }
    public function messages()
    {
        return [
            'code.max' => trans('Trường dữ liệu tối đa :size kí tự.', ['size' => 50]),
            'name.max' => trans('Trường dữ liệu tối đa :size kí tự.', ['size' => 100]),
            'note.max' => trans('Trường dữ liệu tối đa :size kí tự.', ['size' => 100]),
            'tax_id.required' => trans('Thuế không được để trống.'),
            'fee_id.required' => trans('Phí không được để trống.'),
        ];
    }
}
