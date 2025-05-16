<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayRoll extends Model
{
    use HasFactory;

    protected $fillable = [
      'pay_roll_name',
      'start_date',
      'end_date',
      'description',
    ];
}
