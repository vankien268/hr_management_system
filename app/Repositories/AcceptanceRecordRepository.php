<?php

namespace App\Repositories;

use App\Models\AcceptanceRecord;
use App\Repositories\Interfaces\IAcceptanceRecordRepository;

class AcceptanceRecordRepository extends BaseRepository implements IAcceptanceRecordRepository{
    public function __construct(AcceptanceRecord $model)
    {
        $this->model = $model;
    }
}
