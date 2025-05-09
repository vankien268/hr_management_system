<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HrmContract extends Model
{
    use HasFactory;

    protected $table = "contracts";

    protected $fillable = [
        'contract_name',
        'contract_code',
        'contract_number',
        'contact_type_id',
        'department_id',
        'contact_id',
        'signer_user_id',
        'signer_department_id',
        'register_date',
        'time_limited',
        'work_type',
        'basic_salary',
        'effective_date',
        'expiration_date',
        'allowances',
        'note',
    ];

}
