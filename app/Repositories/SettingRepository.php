<?php


namespace App\Repositories;


use App\Models\Setting;
use App\Repositories\Interfaces\ISettingRepository;

class SettingRepository extends BaseRepository implements ISettingRepository {
    public function __construct(Setting $model)
    {
        $this->model = $model;
    }
}
