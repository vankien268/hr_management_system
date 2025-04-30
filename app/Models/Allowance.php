<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allowance extends Model
{
    use HasFactory;

    protected $fillable= [
        'allowance_name',
        'allowance_type',
        'allowed_number_days',
        'allowance_amount',
        'description',
    ];
}
