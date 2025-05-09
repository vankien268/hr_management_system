<?php


namespace App\Repositories;


use App\Models\HrmContract;
use App\Repositories\Interfaces\IHrmContractRepository;

class HrmContractRepository extends BaseRepository implements IHrmContractRepository {
    public function __construct(HrmContract $model)
    {
        $this->model = $model;
    }

}
