<?php

namespace App\Repositories;

use App\Models\SystemFunction;

class SystemFunctionRepository extends BaseRepository implements Interfaces\ISystemFunctionRepository
{
    public function __construct(SystemFunction $model)
    {
        $this->model = $model;
    }
}
