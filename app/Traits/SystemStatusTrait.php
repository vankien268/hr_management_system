<?php

namespace App\Traits;

use App\Enums\StatusTypeEnum;

trait SystemStatusTrait
{
    public function getListStatusType($type = null)
    {
        $typeList = [
            StatusTypeEnum::PROJECT => [
                'value' => StatusTypeEnum::PROJECT,
                'name' => trans('Trạng thái dự án'),
            ],
            StatusTypeEnum::CONTRACT => [
                'value' => StatusTypeEnum::CONTRACT,
                'name' => trans('Trạng thái hợp đồng'),
            ],
            StatusTypeEnum::CUSTOMER => [
                'value' => StatusTypeEnum::CUSTOMER,
                'name' => trans('Trạng thái khách hàng'),
            ],
            StatusTypeEnum::DIARY_PROJECT => [
                'value' => StatusTypeEnum::DIARY_PROJECT,
                'name' => trans('Trạng thái nhật ký dự án'),
            ],
            StatusTypeEnum::ACCEPTANCE_RECORD => [
                'value' => StatusTypeEnum::ACCEPTANCE_RECORD,
                'name' => trans('Trạng thái biên bản nghiệm thu
                '),
            ],
            StatusTypeEnum::DEPLOYMENT_RECORD => [
                'value' => StatusTypeEnum::DEPLOYMENT_RECORD,
                'name' => trans('Trạng thái biên bản triển khai'),
            ],
            StatusTypeEnum::DISPATCHES => [
                'value' => StatusTypeEnum::DISPATCHES,
                'name' => trans('Trạng thái công văn, thông báo'),
            ],
            StatusTypeEnum::DEPLOYMENT_SCHEDULE => [
                'value' => StatusTypeEnum::DEPLOYMENT_SCHEDULE,
                'name' => trans('Trạng thái lịch triển khai'),
            ]
        ];
        if($type !== null){
            return $typeList[$type]['name'] ?? null;
        }
        return (array)$typeList;
    }

    public function getStatusType()
    {
        return $this->getListStatusType($this->type);
    }
}
