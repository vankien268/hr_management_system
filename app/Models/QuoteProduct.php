<?php

namespace App\Models;

use App\Traits\ProjectPermission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuoteProduct extends BaseModel
{
    use ProjectPermission;
    protected $table = 'quote_products';
    protected $fillable = [
        'quote_id',
        'product_id',
        'price',
        'quantity',
        'amount',
        'tax_rate',
        'fee_rate',
    ];

    /**
     * Get the product that owns the QuoteProduct
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

}
