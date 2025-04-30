<?php

namespace App\Repositories;

use App\Models\District;

class DistrictRepository extends BaseRepository implements Interfaces\IDistrictRepository
{
    public function __construct(District $model)
    {
        $this->model = $model;
    }
    public function getData(){
        $result = $this->model->get();
        return $result;
    }
}
