<?php

namespace App\Http\Requests;
use App\Enums\DeploymentScheduleEnum;
use Illuminate\Foundation\Http\FormRequest;

class DeploymentScheduleUpdateRequest extends FormRequest
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
        $fromDate = @\request()->deploymentSchedule['data'][0]['from_date'];
        $toDate =  @\request()->deploymentSchedule['data'][0]['to_date'];
        return [
            'deploymentSchedule.data.*.title' => ['required', 'max:80'],
            'deploymentSchedule.data.*.status_id' => ['required','numeric', 'exists:system_statuses,id'],
            'deploymentSchedule.data.*.from_date' => ['required', 'date_format:Y-m-d'],
            'deploymentSchedule.data.*.to_date' => ['required', 'date_format:Y-m-d', 'after_or_equal:deploymentSchedule.data.*.from_date'],
            'deploymentSchedule.data.*.project_id' => ['required', 'numeric', 'exists:projects,id'],
            'deploymentSchedule.data.*.contract_type_id' => ['required', 'numeric', 'exists:contract_types,id'],
            'deploymentSchedule.data.*.note' =>['required','max:200'],

            'deploymentScheduleDetail.data.*.*.day' => ['required','date_format:Y-m-d', function($attribute, $value, $fail)
            use($fromDate, $toDate){
                $fromDateNew = strtotime($fromDate);
                $toDateNew = strtotime($toDate);
                $dayNew = strtotime($value);
                if($dayNew < $fromDateNew || $dayNew > $toDateNew) {
                    return $fail(trans('Ngày triển khai phải trong khoảng thời gian thực hiện lịch triển khai.'));
                }
            }],
            'deploymentScheduleDetail.data.*.shift' => [function($attribute, $value, $fail) {
                $arrayShift = [
                    DeploymentScheduleEnum::CA_SANG,
                    DeploymentScheduleEnum::CA_CHIEU,
                    DeploymentScheduleEnum::CA_TOI
                ];
                if(!in_array($value, $arrayShift)) {
                    return $fail(trans('Ca triển khai không hợp lệ.'));
                }
            }],
            'deploymentScheduleDetail.data.*.product_function' => ['nullable', 'max:800'],
            'deploymentScheduleDetail.data.*.description' => ['nullable', 'max:800'],

            'projectImplementer.data.*.id' => ['required', 'numeric', 'exists:users,id'],
        ];
    }

    public function messages()
    {
        return [
            'deploymentSchedule.data.*.title.required' => trans('Tên lịch triển khai không bỏ trống.'),
            'deploymentSchedule.data.*.title.max' => trans('Tên lịch triển khai không quá 80 ký tự.'),

            'deploymentSchedule.data.*.status_id.required' => trans('Trạng thái lịch triển khai không bỏ trống.'),
            'deploymentSchedule.data.*.status_id.numeric' => trans('Trạng thái lịch triển khai không hợp lệ.'),
            'deploymentSchedule.data.*.status_id.exists' => trans('Trạng thái lịch triển khai không tồn tại.'),

            'deploymentSchedule.data.*.from_date.required' => trans('Từ ngày không bỏ trống.'),
            'deploymentSchedule.data.*.from_date.date_format' => trans('Từ ngày không đúng định dạng.'),

            'deploymentSchedule.data.*.to_date.required' => trans('Đến ngày không bỏ trống.'),
            'deploymentSchedule.data.*.to_date.date_format' => trans('Đến ngày không đúng định dạng.'),
            'deploymentSchedule.data.*.to_date.after_or_equal' => trans('Đến ngày phải lớn hơn hoặc bằng trường từ ngày.'),

            'deploymentSchedule.data.*.project_id.required' => trans('Dự án chọn không hợp lệ.'),
            'deploymentSchedule.data.*.project_id.numeric' => trans('Dự án chọn không hợp lệ.'),
            'deploymentSchedule.data.*.project_id.exists' => trans('Dự án chọn không hợp lệ.'),

            'deploymentSchedule.data.*.contract_type_id.required' => trans('Loại hợp đồng không bỏ trống.'),
            'deploymentSchedule.data.*.contract_type_id.numeric' => trans('Loại hợp đồng phải là số.'),
            'deploymentSchedule.data.*.contract_type_id.exists' => trans('Loại hợp đồng không tồn tại.'),

            'deploymentSchedule.data.*.note.required' => trans('Ghi chú không bỏ trống.'),
            'deploymentSchedule.data.*.note.max' => trans('Ghi chú không quá 800 ký tự.'),

            'deploymentScheduleDetail.data.*.*.day.required' => trans('Chi tiết ngày triển khai không bỏ trống.'),
            'deploymentScheduleDetail.data.*.*.day.date_format' => trans('Chi tiết ngày triển khai không đúng định dạng.'),
            'deploymentScheduleDetail.data.*.shift.required' => trans('Ca triển khai không bỏ trống.'),
            'deploymentScheduleDetail.data.*.product_function.max' => trans('Chức năng/sản phẩm không quá 800 ký tự.'),
            'deploymentScheduleDetail.data.*.description.max' => trans('Diễn giải không quá 800 ký tự.'),
            'projectImplementer.data.*.id.required' => trans('Chuyên viên triển khai không bỏ trống.'),
            'projectImplementer.data.*.id.numeric' => trans('Chuyên viên triển khai không hợp lệ.'),
            'projectImplementer.data.*.id.exists' => trans('Chuyên viên triển khai không tồn tại.')
        ];
    }
}
