<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Department extends BaseModel
{
    use NodeTrait;
    protected $table = 'departments';
    protected $fillable = [
        'code',
        'name',
        'note',
        'parent_id',
        'status',
        '_lft',
        '_rgt'
    ];

    public function childrenDepartment()
    {
        return $this->hasMany(Department::class, 'parent_id');
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
