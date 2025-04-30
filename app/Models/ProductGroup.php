<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductGroup extends BaseModel
{
    use NodeTrait;
    protected $table="product_groups";
    protected $casts = [
        'status' => 'bool'
    ];
    protected $fillable= [
        'code',
        'name',
        'note',
        'status',
        '_lft',
        '_rgt',
        'parent_id',
        'tax_id',
        'fee_id'
    ];
    const ROOT = "ROOT";
    public function scopeStatus($query)
    {
        return $query->whereStatus(StatusEnum::USING);
    }

    public function taxRate()
    {
        return $this->belongsTo(TaxFeeRate::class, 'tax_id');
    }
    /**
     * Get the feeRate that owns the ProductGroup
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function feeRate(): BelongsTo
    {
        return $this->belongsTo(TaxFeeRate::class, 'fee_id');
    }
    /**
     * Get the productGroup that owns the ProductGroup
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function productGroup(): BelongsTo
    {
        return $this->belongsTo(ProductGroup::class, 'parent_id');
    }
    /**
     * Get all of the productGroups for the ProductGroup
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productGroups()
    {
        return $this->hasMany(ProductGroup::class, 'parent_id');
    }

    /**
     * Get all of the products for the ProductGroup
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
