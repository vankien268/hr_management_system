<?php

namespace App\Repositories;

use App\Models\DeploymentSchedule;
use App\Repositories\Interfaces\IDeploymentScheduleRepository;

class DeploymentScheduleRepository extends BaseRepository implements IDeploymentScheduleRepository {
    public function __construct(DeploymentSchedule $model)
    {
        $this->model = $model;
    }

}
