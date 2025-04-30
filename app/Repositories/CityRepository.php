<?php

namespace App\Repositories;

use App\Models\City;

class CityRepository extends BaseRepository implements Interfaces\ICityRepository
{
    public function __construct(City $model)
    {
        $this->model = $model;
    }

    public function getData(){
        $result = $this->model->get();
        return $result;
    }
}
