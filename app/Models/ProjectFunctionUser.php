<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectFunctionUser extends BaseModel
{
    protected $table="project_function_user";
    protected $fillable = [
        'user_id',
        'project_id',
        'system_function_id'
    ];
}
