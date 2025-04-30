<?php

namespace App\Http\Requests;
use App\Models\SystemStatus;

use Illuminate\Foundation\Http\FormRequest;

class DispatchStoreRequest extends FormRequest
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
            'code' => ['required', 'unique:dispatches,code', 'max:30', 'regex:/^[0-9A-Z.\_]+$/'],
            'number' => ['required', 'unique:dispatches,number', 'max:30', 'regex:/^[0-9A-Z.\_]+$/'],
            'name' => 'required|max:50',
            'type' => 'required',
            'date' => 'nullable|date_format:Y-m-d|before_or_equal:today',
            'project_id' => ['required', 'numeric','exists:projects,id'],
            'customer_id' => ['required', 'numeric','exists:customers,id'],
            'content' => 'nullable|max:200',
            'sender' => 'nullable',
            'receiver' => 'nullable',
            'note' => 'nullable|max:100',
            'from_date' => 'required|date_format:Y-m-d|after_or_equal:today|before_or_equal:to_date',
            'to_date' => 'required|date_format:Y-m-d|after_or_equal:today|after_or_equal:from_date',
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
            'code.required' => trans('Mã công văn, thông báo không bỏ trống.'),
            'code.unique' => trans('Mã công văn, thông báo đã có.'),
            'code.max' => trans('Mã công văn, thông báo không quá 30 ký tự.'),
            'code.regex' => trans('Mã công văn, thông báo không chứa khoảng trắng, tiếng Việt không dấu.'),
            'number.required' => trans('Số công văn, thông báo không bỏ trống.'),
            'number.unique' => trans('Số công văn, thông báo đã có.'),
            'number.max' => trans('Số công văn, thông báo không quá 30 ký tự.'),
            'number.regex' => trans('Số công văn, thông báo không chứa khoảng trắng, tiếng Việt không dấu.'),
            'name.required' => trans('Tên công văn, thông báo không bỏ trống.'),
            'name.max' => trans('Tên công văn, thông báo không quá 50 ký tự.'),
            'project_id.required' => trans('Dự án không bỏ trống.'),
            'project_id.exists' => trans('Dự án không tồn tại.'),
            'customer_id.required' => trans('Khách hàng không bỏ trống.'),
            'customer_id.exists' => trans('Khách hàng không tồn tại.'),
            'content.required' => trans('Nội dung không được bỏ trống.'),
            'content.max' => trans('Nội dung không quá 200 ký tự.'),
            'note.max' => trans('Ghi chú không quá 100 ký tự.'),
            'from_date.required' => trans('Ngày bắt đầu hiệu lực không được để trống'),
            'from_date.date_format' => trans('Không đúng định dạng'),
            'from_date.after_or_equal' => trans('Không lấy ngày quá khứ'),
            'from_date.before_or_equal' => trans('Không vượt quá ngày "Đến ngày"'),
            'to_date.required' => trans('Ngày kết thúc hiệu lực không được để trống'),
            'to_date.date_format' => trans('Không đúng định dạng'),
            'to_date.after_or_equal' => trans('Không lấy ngày quá khứ'),
            'to_date.after_or_equal' => trans('Không lấy ngày trước ngày "Từ ngày"'),
            'status_id.required' => trans('Trạng thái không được để trống'),
            'filesArr.*.max' => trans('File không quá 5MB'),
            'filesArr.*.mimes' => trans('Không đúng định dạng files'),
            'filesArr.max' => trans('Không được quá 10 files'),
        ];
    }
}
