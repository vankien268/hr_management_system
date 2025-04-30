<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractUser extends BaseModel
{
    protected $table = 'contract_users';
    protected $fillable = [
        'contract_id',
        'user_id',
        'note',
        'status'
    ];
}
