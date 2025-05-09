<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    const TYPE_ENTERPRISE_INSURANCE_PAID = "ENTERPRISE_INSURANCE_PAID"; # Bảo hiểm

    const TYPE_TAX_CALCUL = "TAX_CALCUL"; # Thuế

    protected $fillable= [
        'type',
        'object_id',
        'valid',
        'value',
    ];
}
