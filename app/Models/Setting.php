<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    const TYPE_TAX_CALCUL = "TAX_CALCUL"; # Thuế
    const TYPE_WORKER_INSURANCE_PAID = "WORKER_INSURANCE_PAID"; # BH ng lao động trả
    const TYPE_ENTERPRISE_INSURANCE_PAID = "ENTERPRISE_INSURANCE_PAID"; # BH ng doanh nghiệp trả

    protected $fillable= [
        'type',
        'object_id',
        'valid',
        'value',
    ];
}
