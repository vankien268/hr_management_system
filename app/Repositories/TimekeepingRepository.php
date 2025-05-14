<?php


namespace App\Repositories;


use App\Models\Timekeeping;
use App\Repositories\Interfaces\ITimekeepingRepository;

class TimekeepingRepository extends BaseRepository implements ITimekeepingRepository
{
    public function __construct(Timekeeping $model)
    {
        $this->model = $model;
    }
}
