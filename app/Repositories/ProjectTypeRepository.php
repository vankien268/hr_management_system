<?php

namespace App\Repositories;

use App\Models\ProjectType;
use App\Repositories\Interfaces\IProjectTypeRepository;

class ProjectTypeRepository extends BaseRepository implements IProjectTypeRepository{
    public function __construct(ProjectType $model)
    {
        $this->model = $model;
    }

    public function getAllData($request)
    {
        $nameOrCode = $request->get('nameOrCode');
        $projectType = $this->model->with('project')
        ->when($nameOrCode, function($query) use($nameOrCode){
            return $query->where('name', 'like', '%'.$nameOrCode.'%')->orWhere('code', 'like', '%'.$nameOrCode.'%');
        });
        return $projectType;
    }
}
