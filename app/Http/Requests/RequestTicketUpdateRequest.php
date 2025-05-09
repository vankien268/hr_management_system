<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestTicketUpdateRequest extends FormRequest
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
//            valid_workflow_id
            'request_title' => 'required|string',
            'workflow_id' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'approval_type' => 'integer',
            'request_description' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'request_title.required' => 'Tên phiếu yêu cầu không bỏ trống.',
            'workflow_id.required' => 'Loại quy trình không bỏ trống.',
            'request_description.required' => 'Nội dung/Lý do không bỏ trống.',
            'workflow_id.integer' => 'Loại quy trình phải là số.',
            'request_title.string' => 'Tên phiếu yêu cầu phải là chuỗi.',

            'start_date.required' => 'Từ ngày không bỏ trống.',
            'end_date.required' => 'Đến ngày không bỏ trống.',

            'start_date.date' => 'Từ ngày phải là datetime.',
            'end_date.date' => 'Đến ngày phải là datetime.',

            'end_date.after' => 'Đến ngày phải nhỏ hơn từ ngày.',

//          'start_date.before' => 'Từ ngày phải lớn hơn từ ngày.',

        ];
    }
}
