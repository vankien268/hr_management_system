<?php

namespace App\Repositories;

use App\Models\Ward;

class WardRepository extends BaseRepository implements Interfaces\IWardRepository
{
    public function __construct(Ward $model)
    {
        $this->model = $model;
    }
    public function getData(){
        $result = $this->model->get();
        return $result;
    }
}
