<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectUser extends BaseModel
{
    protected $table = 'project_user';
    protected $fillable = [
        'project_id',
        'user_id',
        'note',
        'status'
    ];
}
