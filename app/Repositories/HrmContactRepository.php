<?php


namespace App\Repositories;


use App\Models\HrmContact;
use App\Repositories\Interfaces\IHrmContactRepository;

class HrmContactRepository extends BaseRepository implements IHrmContactRepository {
    public function __construct(HrmContact $model)
    {
        $this->model = $model;
    }

}
