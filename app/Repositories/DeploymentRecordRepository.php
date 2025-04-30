<?php

namespace App\Repositories;

use App\Models\DeploymentRecord;
use App\Repositories\Interfaces\IDeploymentRecordRepository;

class DeploymentRecordRepository extends BaseRepository implements IDeploymentRecordRepository{
    public function __construct(DeploymentRecord $model)
    {
        $this->model = $model;
    }
}
