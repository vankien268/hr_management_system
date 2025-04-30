<?php

namespace App\Repositories;

use App\Models\AnnexContract;

class AnnexContractRepository extends BaseRepository implements Interfaces\IAnnexContractRepository
{
    public function __construct(AnnexContract $model)
    {
        $this->model = $model;
    }
}
