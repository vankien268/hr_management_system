<?php

namespace App\Repositories;

use App\Models\Task;

class TaskRepository extends BaseRepository implements Interfaces\ITaskRepository
{
    public function __construct(Task $model)
    {
        $this->model = $model;
    }
}