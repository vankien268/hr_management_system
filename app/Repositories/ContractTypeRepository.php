<?php

namespace App\Repositories;

use App\Enums\StatusEnum;
use App\Models\ContractType;

class ContractTypeRepository extends BaseRepository implements Interfaces\IContractTypeRepository
{
    public function __construct(ContractType $model)
    {
        $this->model = $model;
    }
    public function getData()
    {
        $requestData = request()->all();

        if(isset($requestData['getAll']) && $requestData['getAll'] == 'true'){
            $results = $this->model->query();
        }else{
            $results = $this->model;
        }
        if (isset($requestData['using']) && in_array($requestData['using'], [true, 1])) {
            $results->where('status', StatusEnum::USING);
        }

        if (array_key_exists('search', $requestData) && $requestData['search'] !== null) {
            $results->where('code', 'like', '%' . $requestData['search'] . '%')->orWhere('name', 'like', '%' . $requestData['search'] . '%');
        }

        return $results;
    }
    public function formatDataStore()
    {
        $requestData = request()->all();
        return $requestData;
    }
    public function formatDataUpdate()
    {
        $requestData = request()->all();
        unset($requestData['code']);
        return $requestData;
    }
}
