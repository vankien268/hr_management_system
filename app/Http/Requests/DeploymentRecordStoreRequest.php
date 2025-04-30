<?php

namespace App\Http\Requests;

use App\Models\SystemStatus;
use Illuminate\Foundation\Http\FormRequest;

class DeploymentRecordStoreRequest extends FormRequest
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
            'code' => ['required', 'unique:deployment_records,code', 'max:30', 'regex:/^[0-9A-Z.\_]+$/'],
            'title' => 'required|max:80',
            'project_id' => ['required', 'numeric','exists:projects,id'],
            'handover_date' => 'required|date_format:Y-m-d',
            'handover_person' => 'required|max:30',
            'receiver' => 'required|max:30',
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
            'code.required' => trans('Mã không bỏ trống.'),
            'code.unique' => trans('Mã đã có.'),
            'code.max' => trans('Mã không quá 30 ký tự.'),
            'code.regex' => trans('Mã không chứa khoảng trắng, tiếng Việt không dấu.'),
            'title.required' => trans('Tiêu đề không bỏ trống.'),
            'title.max' => trans('Tiêu đề không quá 30 ký tự.'),
            'project_id.required' => trans('Dự án không bỏ trống.'),
            'project_id.exists' => trans('Dự án không tồn tại.'),
            'handover_date.required' => trans('Ngày không được bỏ trống.'),
            'handover_date.date_format' => trans('Không đúng định dạng.'),
            'handover_person.required' => trans('Người bàn giao không bỏ trống.'),
            'handover_person.max' => trans('Người bàn giao không quá 30 ký tự.'),
            'receiver.required' => trans('Người tiếp nhận không bỏ trống.'),
            'receiver.max' => trans('Người tiếp nhận không quá 30 ký tự.'),
            'note.max' => trans('Ghi chú không quá 200 ký tự.'),
            'status_id.required' => trans('Trạng thái không được để trống'),
            'filesArr.*.mimes' => trans('Không đúng định dạng files'),
            'filesArr.*.max' => trans('File không quá 5MB'),
            'filesArr.max' => trans('Không được quá 10 files'),
        ];
    }
}
