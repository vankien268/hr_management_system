<?php

namespace App\Repositories;

use App\Models\PaymentDetail;

class PaymentDetailRepository extends BaseRepository implements Interfaces\IPaymentDetailRepository
{
    public function __construct(PaymentDetail $model)
    {
        $this->model = $model;
    }
}
