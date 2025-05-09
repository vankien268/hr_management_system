<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InitValue extends Model
{
    use HasFactory;

    const INIT_NAME_INTERNAL_FUND_TYPE = "INTERNAL_FUND_TYPE";
    const INIT_NAME_INTERNAL_FUND = "INTERNAL_FUND";

    protected $fillable= [
        'init_name',
        'init_value',
    ];
}
