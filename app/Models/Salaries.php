<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salaries extends Model
{
    use HasFactory;
    protected $fillable = [
      'name',
      'month',
      'year',
      'department_ids',
      'department_names',
    ];
}
