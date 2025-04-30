<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Repositories\Interfaces\ISystemStatusRepository;

class UpdateSystemStatusRequest extends FormRequest
{
    protected $systemStatusRepository;
    /**
     * Summary of __construct
     * @param \App\Repositories\Interfaces\ISystemStatusRepository $systemStatusRepository
     */
    public function __construct(ISystemStatusRepository $systemStatusRepository)
    {
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
        return [
            'type' => [
                function ($attribute, $value, $fail) {
                    if ($value === null) {
                        return $fail(trans('Loại trạng thái không hợp lệ.'));
                    }
                    $status = $this->systemStatusRepository->model()->getListStatusType($value);
                    if(!$status){
                        return $fail(trans('Loại trạng thái không hợp lệ.'));
                    }
                }
            ],
            'name' => [
                'max:50',
                function ($attribute, $value, $fail) {
                    if ($value === null) {
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
