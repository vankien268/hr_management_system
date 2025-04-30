<?php

namespace App\Repositories;

use App\Enums\StatusEnum;
use App\Models\SystemStatus;
use App\Enums\StatusTypeEnum;
use App\Repositories\BaseRepository;

class SystemStatusRepository extends BaseRepository implements Interfaces\ISystemStatusRepository
{
    public function __construct(SystemStatus $model)
    {
        $this->model = $model;
    }

    public function getStatusType()
    {
        return $this->model->getListStatusType();
    }

    public function getData()
    {
        $requestData = request()->all();

        $results = $this->model->with(['customers', 'projects', 'contracts', 'tasks']);

        if (isset($requestData['type']) && $requestData['type'] !== null) {
            $results->where('type', $requestData['type']);
        }

        if (isset($requestData['using']) && $requestData['using'] !== null) {
            $results->where('status', StatusEnum::USING);
        }
        return $results->orderBy('type', 'ASC')->latest('id');
    }
    public function formatDataStore($data)
    {

        $data['status'] = true;

        return $data;
    }
    public function formatDataUpdate()
    {
        $dataUpdate = request()->all();

        return $dataUpdate;
    }
}
