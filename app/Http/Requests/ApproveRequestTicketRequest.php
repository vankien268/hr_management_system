<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApproveRequestTicketRequest extends FormRequest
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
        if(request()->request_status == 1) {
           return [
                'number_leave_day' => 'required|numeric'
            ];
        }


        return [];
    }

    public function messages()
    {
        return [
            'number_leave_day.required' => 'Số ngày nghỉ không bỏ trống.'
        ];
    }
}
