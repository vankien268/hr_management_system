<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends BaseModel
{
    protected $table = 'tasks';
    protected $fillable = [
        'date',
        'user_id',
        'project_id',
        'status_id',
        'description',
        'note'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
