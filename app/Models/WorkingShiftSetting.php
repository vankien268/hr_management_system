<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkingShiftSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'shift_type',
        'shift_title',
        'description',
        'active',
        'shift_weekdays',
        'attributes',
        'valid',
    ];

}
