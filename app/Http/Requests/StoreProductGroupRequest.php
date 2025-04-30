<?php

namespace App\Http\Requests;

use App\Repositories\Interfaces\IProductGroupRepository;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductGroupRequest extends FormRequest
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
            'code' => [
                'required',
                'max:50',
                function($attribute, $value, $fail){
                    if($value === null){
                        return;
                    }
                    $checkCodeUnique = $this->productGroupRepository->model()->where('code', 'like', $value)->first();
                    if($checkCodeUnique){
                        return $fail(trans('Mã phải là duy nhất.'));
                    }
                }
            ],
            'name' => [
                'required',
                'max:100'
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
            'code.required' => trans('Mã không được để trống.'),
            'name.required' => trans('Tên không được để trống.'),
            'code.max' => trans('Trường dữ liệu tối đa :size kí tự.', ['size' => 50]),
            'name.max' => trans('Trường dữ liệu tối đa :size kí tự.', ['size' => 100]),
            'note.max' => trans('Trường dữ liệu tối đa :size kí tự.', ['size' => 100]),
            'tax_id.required' => trans('Thuế không được để trống.'),
            'fee_id.required' => trans('Phí không được để trống.'),
        ];
    }
}
