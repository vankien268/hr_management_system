<?php

namespace App\Repositories;

use App\Models\ContractModule;

class ContractModuleRepository extends BaseRepository implements Interfaces\IContractModuleRepository
{
    public function __construct(ContractModule $model)
    {
        $this->model = $model;
    }
}
