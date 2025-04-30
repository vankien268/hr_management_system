<?php

namespace App\Repositories;

use App\Models\Unit;
use App\Repositories\Interfaces\IUnitRepository;

class UnitRepository extends BaseRepository implements IUnitRepository {
    public function __construct(Unit $model)
    {
        $this->model = $model;
    }

}
