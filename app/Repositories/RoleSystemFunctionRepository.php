<?php

namespace App\Repositories;

use App\Models\RoleSystemFunction;

class RoleSystemFunctionRepository extends BaseRepository implements Interfaces\IRoleSystemFunctionRepository
{
    public function __construct(RoleSystemFunction $model)
    {
        $this->model = $model;
    }
}
