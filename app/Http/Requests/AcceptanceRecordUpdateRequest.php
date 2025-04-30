<?php

namespace App\Http\Requests;
use App\Models\SystemStatus;

use Illuminate\Foundation\Http\FormRequest;

class AcceptanceRecordUpdateRequest extends FormRequest
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
            'title' => 'required|max:80',
            'project_id' => ['required', 'numeric','exists:projects,id'],
            'sent_date' => 'required|date_format:Y-m-d',
            'sender' => 'required|max:30',
            'receiver' => 'required|max:30',
            'acceptance_date' => 'required|date_format:Y-m-d',
            'warranty_period' => 'required',
            'note' => 'nullable|max:200',
            'status_id' => [
                'required',
                function($attribute, $value, $fail){
                    if($value === null){
                        return;
                    }
                    if(!is_numeric($value)){
                        return $fail(trans('Trạng thái không tồn tại.'));
                    }
                    $checkExistStatus = SystemStatus::find($value);
                    if(!$checkExistStatus){
                        return $fail(trans('Trạng thái không tồn tại.'));
                    }
                    if($checkExistStatus->status == false){
                        return $fail(trans('Trạng thái không tồn tại.'));
                    }
                }
            ],
            'filesArr.*' => 'mimes:doc,docx,pdf,xls,xlsx,png,jpeg|max:' . env('MAX_FILE_SIZE',5242880),
            'filesArr' => 'max:10',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => trans('Tiêu đề không bỏ trống.'),
            'title.max' => trans('Tiêu đề không quá 80 ký tự.'),
            'project_id.required' => trans('Dự án không bỏ trống.'),
            'sent_date.required' => trans('Ngày không được bỏ trống.'),
            'sent_date.date_format' => trans('Không đúng định dạng.'),
            'sender.required' => trans('Người gửi không bỏ trống.'),
            'sender.max' => trans('Người gửi không quá 30 ký tự.'),
            'receiver.required' => trans('Người nhận không bỏ trống.'),
            'receiver.max' => trans('Người nhận không quá 30 ký tự.'),
            'acceptance_date.required' => trans('Ngày nghiệm thu không bỏ trống.'),
            'acceptance_date.date_format' => trans('Không đúng định dạng.'),
            'warranty_period.required' => trans('Thời gian bảo hành không được để trống'),
            'note.max' => trans('Ghi chú không quá 200 ký tự.'),
            'status_id.required' => trans('Trạng thái không được để trống'),
            'filesArr.*.mimes' => trans('Không đúng định dạng files'),
            'filesArr.*.max' => trans('File không quá 5MB'),
            'filesArr.max' => trans('Không được quá 10 files'),
        ];
    }
}
