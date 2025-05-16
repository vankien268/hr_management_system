<?php


namespace App\Repositories;


use App\Models\PayRoll;
use App\Repositories\Interfaces\IPayRollRepository;

class PayRollRepository extends BaseRepository implements IPayRollRepository
{
    public function __construct(PayRoll $model)
    {
        $this->model = $model;
    }
}
