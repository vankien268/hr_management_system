<?php

namespace App\Repositories;

// use App\Models\ActivityLog;
// use Spatie\Activitylog\Models\Activity;
use App\Models\ActivityLog;
use App\Repositories\Interfaces\IActivityLogRepository;

class ActivityLogRepository extends BaseRepository implements IActivityLogRepository {
    public function __construct(ActivityLog $model)
    {
        $this->model = $model;
    }

}
