<?php

namespace App\Traits;

use App\Enums\QuoteStatusEnum;

trait QuoteTrait
{
    public function getTextStatus()
    {
        switch ($this->status) {
            case QuoteStatusEnum::NOT_APPROVED_YET:
                return trans('Chưa duyệt');
            case QuoteStatusEnum::APPROVED:
                return trans('Đã duyệt');
            case QuoteStatusEnum::CANCELLED:
                return trans('Đã hủy');
        }
    }
}
