<?php

namespace App\Models;

use App\Enums\ProductEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable= [
        'code',
        'name',
        'price',
        'edit_price',
        'image_link',
        'status',
        'product_group_id',
        'unit_id',
        'note'
    ];

    public function productGroup()
    {
        return $this->belongsTo(ProductGroup::class, 'product_group_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function scopeStatus($query)
    {
        return $query->whereStatus(ProductEnum::USING);
    }

    public function quoteProducts()
    {
        return $this->hasMany(quoteProduct::class, 'product_id');
    }
}
