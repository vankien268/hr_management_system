<?php


namespace App\Repositories;


use App\Models\Salaries;

class SalariesRepository extends BaseRepository implements Interfaces\ISalariesRepository
{
    public function __construct(Salaries $model)
    {
        $this->model = $model;
    }
}
