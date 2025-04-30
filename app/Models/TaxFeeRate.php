<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxFeeRate extends BaseModel
{
    protected $table = 'tax_fee_rates';
    protected $fillable = [
        'code',
        'description',
        'rate',
        'type',
        'status',
        'note',
    ];
    const THUE = 0;
    const PHI = 1;
    const TYPE_TAX = [
        'Thuế',
        'Phí'
    ];
    public function productGroup()
    {
        return $this->hasMany(ProductGroup::class,'tax_id');
    }
}
