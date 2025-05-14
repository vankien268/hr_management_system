<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryGrade extends Model
{
    use HasFactory;

    protected $casts = [
        'attributes' => 'array', // hoặc 'json'
    ];

    protected $fillable =  [
        'name',
        'coefficient_one',
        'value_one',
        'coefficient_two',
        'value_two',
        'coefficient_three',
        'value_three',
        'coefficient_four',
        'value_four',
        'coefficient_five',
        'value_five',
        'coefficient_six',
        'value_six',
        'coefficient_seven',
        'value_seven',
        'coefficient_eight',
        'value_eight',
        'valid',
        'attributes',
    ];
}
