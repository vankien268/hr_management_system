<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timekeeping extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shift_id',
        'check_in',
        'check_out',
        'checkin_date',
        'description',
        'attributes',
        'logs',
        'valid',
    ];

}
