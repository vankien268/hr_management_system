<?php


namespace App\Repositories;


use App\Models\Allowance;
use App\Repositories\Interfaces\IAllowanceRepository;

class AllowanceRepository extends BaseRepository implements IAllowanceRepository
{
    public function __construct(Allowance $model)
    {
        $this->model = $model;
    }
}
