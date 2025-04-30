<?php

namespace App\Http\Requests;
use App\Models\SystemStatus;
use Illuminate\Foundation\Http\FormRequest;

class DispatchUpdateRequest extends FormRequest
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
            'number' => ['nullable','max:30'],
            'name' => 'required|max:50',
            'type' => 'required',
            'date' => 'nullable',
            'project_id' => ['required', 'numeric','exists:projects,id'],
            'customer_id' => ['required', 'numeric','exists:customers,id'],
            'content' => 'nullable|max:200',
            'sender' => 'nullable',
            'receiver' => 'nullable',
            'note' => 'nullable|max:100',
            'from_date' => 'required|date_format:Y-m-d|before_or_equal:to_date',
            'to_date' => 'required|date_format:Y-m-d|after_or_equal:from_date',
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
            'number.max' => trans('Số công văn, thông báo không quá 30 ký tự.'),
            'name.required' => trans('Tên công văn, thông báo không bỏ trống.'),
            'name.max' => trans('Tên công văn, thông báo không quá 50 ký tự.'),
            'project_id.required' => trans('Dự án không bỏ trống.'),
            'project_id.exists' => trans('Dự án đã tồn tại.'),
            'customer_id.required' => trans('Khách hàng không bỏ trống.'),
            'customer_id.exists' => trans('Khách hàng đã tồn tại.'),
            'content.required' => trans('Nội dung không được bỏ trống.'),
            'content.max' => trans('Nội dung không quá 200 ký tự.'),
            'note.max' => trans('Ghi chú không quá 100 ký tự.'),
            'from_date.required' => trans('Ngày bắt đầu hiệu lực không được để trống'),
            'from_date.date_format' => trans('Không đúng định dạng'),
            'from_date.before_or_equal' => trans('Ngày bắt đầu hiệu lực không vượt quá ngày kết thúc'),
            'to_date.required' => trans('Ngày kết thúc hiệu lực không được để trống'),
            'to_date.date_format' => trans('Không đúng định dạng'),
            'to_date.before_or_equal' => trans('Ngày kết thúc hiệu lực không trước ngày bắt đầu'),
            'status_id.required' => trans('Trạng thái không được để trống'),
            'filesArr.*.mimes' => trans('Không đúng định dạng files'),
            'filesArr.*.max' => trans('File không quá 5MB'),
            'filesArr.max' => trans('Không được quá 10 files'),
        ];
    }
}
