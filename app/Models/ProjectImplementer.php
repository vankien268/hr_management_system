<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectImplementer extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'deployment_schedule_id',
        'status'
    ];
}
