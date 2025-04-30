<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends BaseModel
{
    protected $table = 'units';
    protected $fillable = [
        'code',
        'name',
        'status',
        'note'
    ];
    public function scopeStatus($query)
    {
        return $query->whereStatus(StatusEnum::USING);
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
