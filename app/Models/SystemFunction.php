<?php

namespace App\Models;

use App\Enums\SystemFunctionEnum;
use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SystemFunction extends BaseModel
{
    use NodeTrait;

    protected $table = 'system_functions';
    protected $fillable = [
        'code',
        'name',
        '_lft',
        '_rgt',
        'parent_id',
        'related_array_id',
        'blocked_array_id',
        'route_name',
        'type',
        'status',
        'function_group',
        'is_role_menu',
        'position',
    ];

    /**
     * Get the productGroup that owns the ProductGroup
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function function(): BelongsTo
    {
        return $this->belongsTo(ProductGroup::class, 'parent_id');
    }
    /**
     * Get the productGroup that owns the ProductGroup
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function functions(): HasMany
    {
        return $this->hasMany(ProductGroup::class, 'parent_id');
    }

    public function scopeTypeFunction($query, $type)
    {
        return $query->whereType($type);
    }

    public function scopeStatusActive($query)
    {
        return $query->whereStatus(SystemFunctionEnum::STATUS_ACTIVE);
    }
}
