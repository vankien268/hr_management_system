<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLog extends BaseModel
{
    protected $table = 'user_logs';
    protected $fillable = [
        'device_name',
        'ip_address',
        'user_agent',
        'visitor_id',
        'login_at',
        'user_id'
    ];
}
