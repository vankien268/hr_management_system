<?php


namespace App\Repositories;


use App\Models\WorkingShiftSetting;
use App\Repositories\Interfaces\IWorkingShiftSettingRepository;

class WorkingShiftSettingRepository extends BaseRepository implements IWorkingShiftSettingRepository {
    public function __construct(WorkingShiftSetting $model)
    {
        $this->model = $model;
    }

}
