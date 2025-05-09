<?php


namespace App\Repositories;


use App\Models\workflow;
use App\Repositories\Interfaces\IWorkflowRepository;

class WorkflowRepository extends BaseRepository implements IWorkflowRepository {
    public function __construct(workflow $model)
    {
        $this->model = $model;
    }
}
