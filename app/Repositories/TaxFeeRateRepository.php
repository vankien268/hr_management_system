<?php

namespace App\Repositories;

use App\Enums\StatusEnum;
use App\Models\TaxFeeRate;
use App\Repositories\Interfaces\ITaxFeeRateRepository;

class TaxFeeRateRepository extends BaseRepository implements ITaxFeeRateRepository {
    public function __construct(TaxFeeRate $model)
    {
        $this->model = $model;
    }

    public function getListSelect($type = null){
        $result = $this->model->query();
        if($type !== null){
            $result->where('type', $type);
        }
        return $result->latest('id');
    }
}
