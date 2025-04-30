<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectType extends BaseModel
{
    protected $table = 'project_types';
    protected $fillable = [
        'code',
        'name',
        'note',
        'status'
    ];

    public function project()
    {
        return $this->hasOne(Project::class);
    }
}
