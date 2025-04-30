<?php

namespace App\Repositories;

use App\Models\Bank;
use App\Repositories\Interfaces\IBankRepository;

class BankRepository extends BaseRepository implements IBankRepository {
    public function __construct(Bank $model)
    {
        $this->model = $model;
    }

}
