<?php


namespace App\Repositories;


use App\Models\SalaryGrade;
use App\Repositories\Interfaces\ISalaryGradeRepository;

class SalaryGradeRepository extends BaseRepository implements ISalaryGradeRepository {
    public function __construct(SalaryGrade $model)
    {
        $this->model = $model;
    }
}
