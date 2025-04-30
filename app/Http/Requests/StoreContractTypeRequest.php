<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Repositories\Interfaces\IContractTypeRepository;

class StoreContractTypeRequest extends FormRequest
{
    protected $contractTypeRepository;
    public function __construct(IContractTypeRepository $contractTypeRepository)
    {
        $this->contractTypeRepository = $contractTypeRepository;
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
                function($attribute, $value, $fail){
                    if($value === null){
                        return;
                    }
                    $checkCodeUnique = $this->contractTypeRepository->model()->where('code', 'like', $value)->first();
                    if($checkCodeUnique){
                        return $fail(trans('Mã phải là duy nhất.'));
                    }
                }
            ],
            'name' => [
                'required',
                'max:50',
            ],
            'note' => [
                'max:100',
            ]
        ];
    }
    public function messages()
    {
        return [
            'code.required' => trans('Mã không được để trống.'),
            'name.required' => trans('Tên không được để trống.'),
            'name.max' => trans('Trường dữ liệu tối đa :size kí tự.', ['size' => 50]),
            'note.required' => trans('Mô tả/diễn giải không được để trống.'),
            'note.max' => trans('Trường dữ liệu tối đa :size kí tự.', ['size' => 100]),
        ];
    }
}
