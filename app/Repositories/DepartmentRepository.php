<?php

namespace App\Repositories;

use App\Models\Department;

class DepartmentRepository extends BaseRepository {
    public function __construct(Department $model)
    {
        $this->model = $model;
    }
}
