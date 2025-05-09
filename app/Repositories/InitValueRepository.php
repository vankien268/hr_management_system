<?php


namespace App\Repositories;


use App\Models\InitValue;
use App\Repositories\Interfaces\IInitValueRepository;

class InitValueRepository extends BaseRepository implements IInitValueRepository {
    public function __construct(InitValue $model)
    {
        $this->model = $model;
    }

}
