<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContractTypeRequest extends FormRequest
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
            'name' => [
                'max:50',
                function($attribute, $value, $fail){
                    if($value === null){
                        return $fail(trans('Tên không được để trống.'));
                    }
                }
            ],
            'note' => [
                'max:100',
            ]
        ];
    }
    public function messages()
    {
        return [
            'name.max' => trans('Trường dữ liệu tối đa :size kí tự.', ['size' => 50]),
            'note.max' => trans('Trường dữ liệu tối đa :size kí tự.', ['size' => 100]),
        ];
    }
}
