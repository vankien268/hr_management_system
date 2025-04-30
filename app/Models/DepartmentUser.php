<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentUser extends BaseModel
{
    protected $table = 'department_users';
    protected $fillable = [
        'department_id',
        'user_id',
        'status'
    ];
}
