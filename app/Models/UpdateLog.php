<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UpdateLog extends BaseModel
{
    protected $table = 'update_logs';
    protected $fillable = [
        'code',
        'entity_id',
        'entity_type',
        'columns',
        'old_data',
        'new_data'
    ];
}
